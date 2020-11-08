<template>
    <div>
        <button @click="toggleFollow" id="follow-btn">{{follow}}</button>
        <success-modal @close="isSuccess = false" v-if="isSuccess">
            <span slot="success-title">{{title}}</span>
            <span slot="success-info">{{message}}</span>
        </success-modal>
    </div>
</template>

<script>
    export default {
        name: "FollowButton",
        props: {
            profile:{},
            friend:{},
        },
        data(){
            return {
                isSuccess: false,
                title: '',
                message: '',
                followProfile: false,
                followAdder: 0
            }
        },
        created(){
            axios.get('/api/v1/follows', {
                params: {
                    profile_id: this.profile.id,
                    friend_id: this.friend.id
                }
            }).then(response=>{
                this.followProfile = response.data.data;
                console.log(response);
            })
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
            toggleFollow(){
                let formData = new FormData();
                formData.append('profile_id', this.profile.id);
                formData.append('friend_id', this.friend.id);

                axios.post('/api/v1/toggleFollow', formData).then(resp=>{
                    if (resp.data.status_code === 201){
                        this.followProfile = !this.followProfile;
                        this.openModal('Success!', resp.data.message);
                        this.$emit('followAdder', this.followProfile ? 1 : -1);
                    }
                    else{
                        this.openModal('Error!', resp.data.message);
                    }
                });
            }
        },
        computed:{
            follow(){
                return this.followProfile ? 'Unfollow' : 'Follow';
            }
        }

    }
</script>

<style scoped>
    #follow-btn{
        padding: 5px 10px;
        border-radius: 3px;
        border-style: solid;
        border-width: 1px;
        font-size: 14px;
        font-weight: 600;
        line-height: 26px;
        outline: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        white-space: nowrap;
        width: 100%;
        background: #0095f6;
        color: #fff;
    }
</style>