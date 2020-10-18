<template>
    <div class="modal">
        <span class="mask" @click="$emit('closeConfirmation')"></span>
        <div class="modal-wrapper">
            <div class="modal-container">
                <div class="modal-body">
                    <h1>Upload Image</h1>
                    <div class="input-block">
                        <!--<span class="input-info">Description</span>-->
                        <div class="relative">
                            <textarea v-model="description" placeholder="Enter Description..." type="text"/>
                        </div>
                    </div>
                    <form id="form1" runat="server">
                        <div class="video-upload input-block" >
                            <img v-if="imgAttached" id="blah" src="#" alt="your image">
                            <div v-if="!imgAttached" class="upload-img-div">
                                <img class="video-upload-image" src="/images/upload.png"/>
                                <span class="video-upload-title">Upload Image</span>
                                <span class="video-upload-input">
                                    <span>browse</span>
                                    <input ref="image" @change="readURL()" id="imgInp" type="file" accept="image/x-png,image/gif,image/jpeg"/>
                                </span>
                            </div>
                        </div>
                    </form>
                    <div v-if="imgAttached" style="display: flex; justify-content: space-between">
                        <button @click="addVideo"  class="button">Save</button>
                        <button  @click="removeImage"  class="button">Remove Image</button>
                    </div>
                </div>
            </div>
        </div>
        <!--<transition name="fade" mode="out-in">-->
            <img v-if="showLoader" src="/images/loader.gif" alt="loader">
        <!--</transition>-->
    </div>
</template>

<script>
    export default {
        name: "AddVideoModal",
        props: {
            profile: {},
        },
        data(){
            return{
                image: null,
                description: '',
                showVideo: false,
                videoSource: null,
                file: null,
                showLoader: false,
                imgAttached: false,
            }
        },
        mounted(){

        },
        methods:{
            addVideo(){
                console.log(this.$refs);
                let img = this.image;
                let headers = {'Content-Type': 'multipart/form-data'};
                this.showLoader = true;
                let data = new FormData();
                data.append('image', img);
                data.append('description', this.description);
                data.append('profile_id', this.profile.id);
                axios.post('/api/v1/post', data, headers)
                    .then(response => {
                        if(response.data.status_code === 201) {
                            this.$emit('imageUploaded', response.data.data);
                            this.$emit('closeConfirmation');
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
                    })
            },
            removeImage(){
                $('#blah').attr('src', '');
                this.imgAttached = false;
            },
             readURL() {
                 let input = this.$refs.image;
                 this.image = this.$refs.image.files[0];
                 if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#blah').attr('src', e.target.result);
                    };
                    this.imgAttached = true;
                    reader.readAsDataURL(input.files[0]);
                 }
             },

        }
    }
</script>

<style lang="scss" scoped>
    .video-upload-title{
        color: white !important;
    }
    .modal-body h1{
        color: white;
    }
    .upload-img-div{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    #blah{
        position: absolute;
        top: 0px;
        left: 0;
        z-index:100;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    video{
        width: 100%;
        margin: 20px 0;
    }
    .video-upload{
        height: 500px;
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