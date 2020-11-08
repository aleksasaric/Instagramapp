<template>
    <div class="container">
        <div class="profile">
            <div class="profile__header">
                <div class="profile__picture">
                    <a :class="{noHover: !isOwner}" class="profile__edit">
                        <i v-if="isOwner" class="fas fa-camera" @click="clickInput()"></i>
                        <img :src="'/storage/' + profile.image" alt="profie picture">
                        <input style="display:none" ref="image" @change="uploadAvatar($event.target.name, $event.target.files)" id="imgInp" type="file" accept="image/x-png,image/gif,image/jpeg"/>
                    </a>
                </div>
                <div class="profile__information">
                    <div class="profile__information__header">
                        <p>{{profile.username}}</p>
                        <follow-button v-if="!isOwner" @followAdder="addOrRemoveFollower" :profile="authUser" :friend="profile"></follow-button>
                        <div v-if="profile.id === authUser.id">
                            <button><a href="/profile/edit">Edit Profile</a></button>
                            <button style="border-radius: 50%" title="Add image" @click="openAddImageModal()">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                    </div>
                    <div class="profile__information__body">
                        <ul>
                            <li><span class="bold">{{profile.posts.length}}</span> posts</li>
                            <li><span class="bold">{{profile.befriended_by_count}}</span> followers</li>
                            <li><span class="bold">{{profile.friends_count}}</span> following</li>
                        </ul>
                    </div>
                    <div class="profile__information__footer">
                        <p><span class="bold">{{profile.name}}</span></p>
                        <p>{{profile.bio}}</p>
                    </div>

                </div>
            </div>

            <div class="profile__middle"></div>
            <div class="profile__pictures">
                <div  v-for="(post, index) in profile.posts" :key="index" class="profile__pictures__container">
                    <img @click="openPost(post)" :src="'/storage/' + post.path" alt="">
                </div>
            </div>

        </div>
        <success-modal @close="isSuccess = false" v-if="isSuccess">
            <span slot="success-title">{{title}}</span>
            <span slot="success-info">{{message}}</span>
        </success-modal>
        <transition name="fade" mode="out-in">
            <post-modal v-if="showImageModal" :profile="this.profile" :post="this.selectedPost"  @closeConfirmation="showImageModal = false">
            </post-modal>
        </transition>
        <transition name="fade" mode="out-in">
            <add-post-modal :profile="profile" v-if="showAddImageModal" @imageUploaded="handleUpload" @closeConfirmation="showAddImageModal = false">
            </add-post-modal>
        </transition>
    </div>
</template>

<script>
    import AddPostModal from "./AddPostModal";
    export default {
        name: "Profile",
        components: {AddPostModal},
        props:{
            prof: null,
            authUser: {}
        },
        computed:{
            isOwner(){
                return this.profile.id === this.authUser.id;
            }
        },
        data(){
            return {
                isSuccess:false,
                message: '',
                title: '',
                imageUploaded: null,
                profile: this.prof,
                showImageModal: false,
                showAddImageModal: false,
                selectedPost: null,
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
            addOrRemoveFollower($var) {
                this.$set(this.profile, 'befriended_by_count', $var > 0 ? this.profile.befriended_by_count + 1 : this.profile.befriended_by_count - 1);
            },
            clickInput(){
                if (!this.isOwner) return;
                $('#imgInp').click();
            },
            uploadAvatar(name, image){

                let img = image[0];
                let headers = {'Content-Type': 'multipart/form-data'};
                this.showLoader = true;
                let data = new FormData();
                data.append('image', img);
                data.append('profile_id', this.profile.id);
                axios.post('/api/v1/avatar', data, headers)
                    .then(response => {
                        if(response.data.status_code === 201) {
                            this.$set(this.profile, 'image', response.data.data.image);
                            this.openModal('Success!', response.data.message);
                        }
                        else{
                            this.openModal('Error!', response.data.message);
                        }
                    })

            },
            handleUpload(data){
                this.profile.posts.push(data.data);
                this.openModal('Success!', data.message);
            },
            openPost(post){
                this.selectedPost = post;
                this.showImageModal = true;
            },
            openAddImageModal(){
                this.showAddImageModal = true;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .noHover{
        pointer-events: none;
        /*cursor: pointer !important;*/
    }
    .profile{

        .profile__edit{
            position: relative;
            cursor: pointer;
        }
        .profile__edit i{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 30px;
            cursor:pointer;
            opacity: 0;
            transition: opacity 1s;
        }
        .profile__edit:hover i {
            opacity: 0.5;
        }

        &__header{
            display: flex;
            position: relative;
         }
        &__header::after{
            content:"";
            position: absolute;
            width: 100%;
            height: 1px;
            top: 20px;
        }
        &__picture{
            width: 300px;
            height: 300px;
        }
        &__picture img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            /*object-position: 50% 50%;*/
            border-radius: 50%;
        }
        &__information{
            margin: 20px;
            width: 40%;
            &__header{
                display: flex;
                justify-content: space-between;
                flex-wrap: wrap;
                p{
                    margin-bottom:unset;
                    font-size: 1.5em;
                    color:black;
                    font-weight: bold;
                }
                button{
                    border: 0;
                    padding: 7px 14px;
                    border: 1px solid gray;
                    border-radius: 10px;
                    outline: none;
                }
                button:active{
                    background: gray;
                    color: white;

                }
            }
            &__body{
                margin: 20px 0 20px 0;
                ul{
                    display: flex;
                    justify-content: space-between;
                }
            }
            &__footer{
               p{
                   margin-bottom:unset;
               }
            }
        }


        &__middle{
            width: 100%;
            height: 1px;
            background: gray;
            margin: 30px 0 30px 0;
        }

        &__pictures{
            margin-left: -10px;
            margin-right: -10px;

            &__container{
                margin:10px;
                width: calc(100%/3 - #{23px});
                display: inline-block;
                cursor: pointer;
            }
            &__container img{
                width: 100%;


            }
        }



    }

    /*.profile__header{*/
       /**/
    /*}*/
    /*.profile__picture{*/
        /*width: 300px;*/
        /*height: 300px;*/
    /*}*/
    /*.profile__picture img{*/
        /*width: 100%;*/
        /*height: 100%;*/
        /*object-fit: cover;*/
        /*!*object-position: 50% 50%;*!*/
        /*border-radius: 50%;*/
    /*}*/
    /*.profile__information{*/

    /*}*/
</style>