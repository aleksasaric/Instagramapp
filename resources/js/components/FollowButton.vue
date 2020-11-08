<template>
    <div>
        <span v-if="!pingingApi" @click="toggleFollow" class="api-button">{{follow}}</span>
        <div class="api-button" v-else>
            <span class="button-loader"></span>
        </div>

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
                pingingApi: false,
                isSuccess: false,
                title: '',
                message: '',
                followProfile: false,
                followAdder: 0
            }
        },
        created(){
            this.pingingApi = true;
            axios.get('/api/v1/follows', {
                params: {
                    profile_id: this.profile.id,
                    friend_id: this.friend.id
                }
            }).then(response=>{
                this.followProfile = response.data.data;
                this.pingingApi = false;
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
                this.pingingApi = true;
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
                    this.pingingApi = false;
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
</style>