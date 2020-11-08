<template>
    <div class="container">
        <div class="edit-wrapper">
            <div class="edit-menu">
                <div class="edit-menu__items">
                    <div :class="[this.activeTab === 1 ? 'active' : '', 'edit-menu__item']"  @click="activateTab(1)">Edit Profile</div>
                    <div :class="[this.activeTab === 2 ? 'active' : '', 'edit-menu__item']" @click="activateTab(2)">Privacy and Security</div>
                    <div :class="[this.activeTab === 3 ? 'active' : '', 'edit-menu__item']" @click="activateTab(3)">Change Password</div>
                </div>
            </div>
            <div class="edit-inputs">
                <div v-if="activeTab===1">

                    <div class="row-input-header">
                        <div class="img-container">
                            <img :src="'/storage/' + profile.image" alt="profile image">
                        </div>
                        <div class="change-picture">
                            <p class="change-picture-name">{{ this.prof.username }}</p>
                            <p onclick="document.getElementById('avatar-uploader').click()" class="change-picture-profile">Change Profile Photo</p>
                            <input @change="handleUpload" style="display:none" id="avatar-uploader" ref="avatar" type="file" accept="image/x-png,image/gif,image/jpeg" name="avatar">
                        </div>
                    </div>

                    <div class="row-input">
                        <label for="row1">Name</label>
                        <input v-model="editProfile.name" id="row1" type="text">
                    </div>
                    <div class="row-input">
                        <label for="row2">Username</label>
                        <input v-model="editProfile.username" id="row2" type="text">
                    </div>
                    <div class="row-input">
                        <label for="row3">Website</label>
                        <input v-model="editProfile.website" id="row3" type="text">
                    </div>
                    <div class="row-input">
                        <label for="row4">Bio</label>
                        <input v-model="editProfile.bio"  id="row4" type="text">
                    </div>
                    <div class="row-input">
                        <label for="row6">Gender</label>
                        <input v-model="editProfile.gender" id="row6" type="text">
                    </div>
                    <div class="row-input">
                       <span class="buttons" @click="updateProfile()">Submit</span>
                    </div>
                    <!--</div>-->
                </div>

                <div class="tab-2-active" v-if="activeTab===2">
                    <div class="privacy">
                        <h2>Account Privacy</h2>
                        <input v-model="editProfile.privateAccount" id="checkbox-1" type="checkbox">
                        <label for="checkbox-1">Private Account</label>
                        <p>When your account is private, only people you approve can see your photos and videos on Instagram. Your existing followers won't be affected.
                        </p>
                    </div>

                </div>
                <div v-if="activeTab===3">
                    <div class="row-input-header">
                        <div class="img-container">
                            <img src="/storage/images/aleksa.jpg" alt="">
                        </div>
                        <div style="padding-right:50px; line-height:40px" class="change-picture">
                            <p class="change-picture-name">{{ this.prof.username }}</p>
                        </div>
                    </div>
                    <div class="row-input">
                        <label for="password">Old Password</label>
                        <input required v-model="editProfile.oldPassword" id="password" type="password">
                    </div>
                    <div class="row-input">
                        <label for="password-new">New Password</label>
                        <input required v-model="editProfile.password" id="password-new" type="password">
                    </div>
                    <div class="row-input">
                        <label for="password-conform">Conform New Password</label>
                        <input required v-model="editProfile.confirmPassword" id="password-conform" type="password">
                    </div>
                    <div class="row-input">
                        <span class="buttons" @click="updateProfile()">Change Password</span>
                    </div>
                </div>
            </div>
        </div>
        <success-modal @close="isSuccess = false" v-if="isSuccess">
            <span slot="success-title">{{title}}</span>
            <span slot="success-info">{{message}}</span>
        </success-modal>
    </div>
</template>

<script>
    export default {
        name: "EditProfile.vue",
        props:{
            prof:{}
        },
        data(){
            return {
                file: null,
                isSuccess: false,
                title: '',
                message: '',
                activeTab: 1,
                errorMessage: '',
                profile: this.prof,
                editProfile:{
                    password: '',
                    oldPassword: '',
                    confirmPassword: '',
                },
            }
        },
        methods:{
            openModal(title, message){
                this.isSuccess = true;
                this.title = title;
                this.message = message;
                setTimeout(() => {
                    this.isSuccess = false;
                }, 5000);
            },
            handleUpload(e){
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.file = files[0];
                let formData = new FormData();
                formData.append('profile_id', this.profile.id);
                formData.append('image', this.file);
                axios.post('/api/v1/avatar', formData).then( response => {
                    if (response.data.status_code === 201) {
                        this.profile = response.data.data;
                        this.openModal('Success!', response.data.message);
                    }
                    else{
                        this.openModal('Error!', response.data.message);
                    }
                });
            },
            activateTab(tabNumber){
                this.activeTab = tabNumber;
            },
            passwordMatch(){
                if (this.editProfile.password !== this.editProfile.confirmPassword) {
                    this.openModal('Error!', 'Password do not match.');
                    return false;
                }
                return true;
            },
            updateProfile(){
                if (!this.passwordMatch()){
                    return;
                }
                axios.post('/api/v1/profile/update', this.editProfile)
                    .then(response => {
                        if(response.data.status_code === 201) {
                            this.openModal('Success!', response.data.message);
                            this.profile = response.data.data;
                            if (this.profile.username !== response.data.data.username){
                                location.reload();
                            }
                        }else{
                            this.openModal('Error!', response.data.message);
                        }
                    });
            },
        },
        mounted(){

        },
        created() {
            this.$set(this.editProfile, 'id', this.prof.id);
            this.$set(this.editProfile, 'name', this.prof.name);
            this.$set(this.editProfile, 'username', this.prof.username);
            this.$set(this.editProfile, 'image', this.prof.image);
            this.$set(this.editProfile, 'website', this.prof.website);
            this.$set(this.editProfile, 'bio', this.prof.bio);
            this.$set(this.editProfile, 'gender', this.prof.gender);
            this.$set(this.editProfile, 'privateAccount', this.prof.is_private);
            this.$set(this.editProfile, 'user_id', this.prof.user_id);
        }
    }
</script>

<style scoped>
    .edit-wrapper{
        height: 80vh;
        width: 100%;
        /*background: whitesmoke;*/
        display: flex;
        justify-content:center;
    }
    .edit-menu{
        width: 20%;
        border: 1px solid rgb(219, 219, 219);
        /*background: #b0d4f1;*/
    }
    .edit-menu__item{
        width: 100%;
        padding: 10px 20px 10px 20px;
        cursor: pointer;
        border-left: rgba(38,38,38,0.1) solid 2px;
    }
    .edit-menu__item:hover{
        background: rgba(38,38,38,0.1);
        border-left: gray 2px solid;
        /*border-left: gray solid 2px;*/
    }
    .edit-inputs{
        /*background: lightblue;*/
        border: 1px solid rgb(219, 219, 219);
        width: 40%;
        display: flex;
        justify-content: center;
    }
    .input-holder{

    }
    .row-input-header{
        display: flex;
        justify-content: flex-end;
        margin: 10px 0 10px 0;
    }
    .row-input-header img{
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .row-input{
        width: 100%;
        display: flex;
        justify-content: flex-end;
        margin: 10px 0 10px 0;
    }
    .row-input label{
       padding-right: 20px;
    }
    .row-input input{
        padding: 0 10px;
    }
    .change-picture{
        padding-right:20px
    }
    .change-picture-name{
        font-size: 1.2em;
        font-weight: bold;
    }
    .change-picture-profile{
        color: #1d68a7;
        cursor: pointer;
    }
    .active{
        border-left: black 2px solid;
    }
    .img-container{
        padding-right: 20px;
    }
    .tab-2-active{
        padding: 40px;
    }
    .buttons{
        background: #00A4FF;
        color: #FFFFFF;
        padding: 6px 12px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
    }

</style>