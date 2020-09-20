<template>
    <div class="modal">
        <span class="mask" @click="$emit('close')"></span>
        <div class="modal-wrapper">
            <div class="modal-container">
                <div class="modal-body">
                    <h1>Add Image</h1>
                    <!--<div class="input-block">-->
                        <!--<span class="input-info">Title <span data-v-465695ac="" class="red">*</span></span>-->
                        <!--<div class="relative">-->
                            <!--<input v-model="video.title" placeholder="Enter text..." type="text"/>-->
                        <!--</div>-->
                    <!--</div>-->
                    <div class="input-block">
                        <span class="input-info">Description</span>
                        <div class="relative">
                            <textarea v-model="description" placeholder="Enter text..." type="text"/>
                        </div>
                    </div>
                    <!--<div class="input-block">-->
                        <!--<span class="input-info">Duration</span>-->
                        <!--<div class="relative">-->
                            <!--<input v-model="video.duration" placeholder="Ex: 1:45" type="text"/>-->
                        <!--</div>-->
                    <!--</div>-->
                    <div v-if="!showVideo" class="video-upload input-block">
                        <img class="video-upload-image" src="/images/upload.png"/>
                        <span class="video-upload-title">Upload Video</span>
                        <span class="video-upload-description">Drag a file to attack or
                            <span class="video-upload-input">
                                <span>browse</span>
                                <input ref="video" type="file" accept="image/x-png,image/gif,image/jpeg"/>
                            </span>
                        </span>
                    </div>
                    <div v-if="showVideo">
                        <video ref="video" controls>
                            <source ref="videoSource" :src="videoSource" />
                        </video>
                    </div>
                    <span @click="addVideo"  class="button">Save</span>
                </div>
            </div>
        </div>
        <!--<transition name="fade" mode="out-in">-->
            <img v-if="showLoader" src="/images/loader.gif" alt="loader">
        <!--</transition>-->
    </div>
</template>

<script>
    // import Loader from '../../loaders/Loader'
    export default {
        name: "AddVideoModal",
        props: {
            get_chapter: {},
            get_video: {}
        },
        data(){
            return{
                description: '',
                showVideo: false,
                videoSource: null,
                file: null,
                showLoader: false,
            }
        },
        mounted(){

        },
        methods:{
            addVideo(){
                let $this = this;
                let postFile = this.$refs.video.files[0];
                let data = new FormData();
                let headers = {'Content-Type': 'multipart/form-data'};
                this.showLoader = true;
                data.append('image', postFile);
                data.append('description', this.description);
                axios.post('/post', data, headers)
                    .then(response => {
                        if(response.data.status_code === 201) {
                            $this.$nextTick(() => {
                                $this.videoSource = response.data.data;
                                // $this.$refs.videoSource.parentElement.load();
                                $this.file = postFile;
                                $this.$forceUpdate();
                            });
                            $this.showLoader = false;
                            $this.showVideo = true;
                        }
                        if(response.data.status_code === 422) {
                            $this.$swal({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                title: 'Error!',
                                text: response.data.message,
                                timer: 3000
                            });
                            $this.showLoader = false;
                            $this.showVideo = false;
                        }
                        console.log(response)
                    })
                    .catch(error => console.error(error.response));
            }
            ,
            handleUpload () {
                let $this = this;
                let postFile = this.$refs.video.files[0];
                let data = new FormData();
                let headers = {'Content-Type': 'multipart/form-data'};
                this.showLoader = true;
                data.append('image', postFile);
                data.append('description', this.description);
                axios.post('/api/v1/post', data, headers)
                    .then(response => {
                        if(response.data.status_code === 201) {
                            $this.$nextTick(() => {
                                $this.videoSource = response.data.data;
                                // $this.$refs.videoSource.parentElement.load();
                                $this.file = postFile;
                                $this.$forceUpdate();
                            });
                            $this.showLoader = false;
                            $this.showVideo = true;
                        }
                        if(response.data.status_code === 422) {
                            $this.$swal({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                title: 'Error!',
                                text: response.data.message,
                                timer: 3000
                            });
                            $this.showLoader = false;
                            $this.showVideo = false;
                        }
                        console.log(response)
                    })
                    .catch(error => console.error(error.response));
            }
        }
    }
</script>

<style lang="scss" scoped>
    video{
        width: 100%;
        margin: 20px 0;
    }
    .video-upload{
        border: 2px dashed #dbe0e6;
        text-align: center;
        position: relative;
        &-cancel,
        &-confirm{
            width: calc(100% /2 - 25px);
            text-transform: uppercase;
            font-size: 14px;
            background: transparent;
            border: 0;
            padding: 15px;
        }
        &-cancel{
            background-color: #f9f9f9;
            color: #354053;
        }
        &-confirm{
            background-color: #354053;
            color: white;
        }
        &-show{
            img{
                width: 100%;
            }
        }
        &-image{
            display: block;
            margin: 20px auto 15px;
        }
        i{
            font-size: 26px;
            display: block;
            margin-bottom: 15px;
        }
        &-title{
            font-size: 14px;
            font-weight: 500;
            font-style: normal;
            font-stretch: normal;
            line-height: 1.39;
            letter-spacing: normal;
            text-align: center;
            color: #354053;
            display: block;
            margin-bottom: 10px;
        }
        &-description{
            font-size: 12px;
            font-weight: 500;
            font-style: normal;
            font-stretch: normal;
            line-height: 1.79;
            letter-spacing: normal;
            text-align: center;
            color: #a2abb3;
            display: block;
        }
        &-input{
            display: block;
            margin-bottom: 20px;
            span{
                color: #235dfe;
            }
            input{
                opacity: 0;
                position: absolute;
                bottom: 0;
                cursor: pointer;
                left: 0;
                right: 0;
                top: 0;
                z-index: 1;
                width: 100%;
            }
        }
    }
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: table;
        transition: opacity .3s ease;
        h1{
            text-align: center;
            margin-bottom: 0;
            text-transform: uppercase;
        }
        &-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .mask{
            background: rgba(0, 0, 0, 0.7);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
        &-body{
            margin: 0;
        }
        &-container {
            background: #fff;
            width: 750px;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
            transition: all .3s ease;
            margin: 0 auto;
            padding: 20px 30px;
        }

        &-footer {
            margin-top: 15px;
        }

        &-enter, &-leave {
            opacity: 0;
        }

        &-enter &-container,
        &-leave &-container {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }
    }
    .input-block{
        margin: 25px 0;
        .input-info{
            font-size: 14px;
            font-weight: 500;
            font-style: normal;
            font-stretch: normal;
            line-height: normal;
            letter-spacing: normal;
            color: #354053;
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }
        .relative{
            position: relative;
            input,
            textarea{
                width: 100%;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                background-color: #f9f9f9;
                outline: none;
                border: 0;
                padding: 15px;
                font-family: Gotham Regular,sans-serif;
                font-size: 12px;
            }
            textarea{
                min-height: 100px;
                resize: none;
            }

        }
        .red{
            color: red;
            font-size: 14px;
        }
    }
    .button{
        background-color: #354053;
        color: white;
        padding: 13px 20px;
        border-radius: 2px;
        outline: none;
        border: 0;
        text-transform: uppercase;
        cursor: pointer;
    }
</style>