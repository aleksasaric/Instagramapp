<template>
    <div class="modal">
        <span class="mask" @click="$emit('closeConfirmation')"></span>
        <div class="modal-wrapper">
            <div class="modal-container">
                <div class="modal-body">
                    <h1>Image uploader</h1>
                    <div class="input-block">
                        <!--<span class="input-info">Description</span>-->
                        <div class="relative">
                            <textarea v-model="description" placeholder="Enter Description..." type="text"/>
                        </div>
                    </div>
                    <form id="form1" runat="server">
                        <div class="post-upload input-block" >
                            <img v-if="imgAttached" id="blah" src="#" alt="your image">
                            <div v-if="!imgAttached" class="upload-img-div">
                                <img class="post-upload-image" src="/images/upload.png"/>
                                <span class="post-upload-title">Upload Image</span>
                                <span class="post-upload-input">
                                    <span>browse</span>
                                    <input ref="image" @change="readURL()" id="imgInp" type="file" accept="image/x-png,image/gif,image/jpeg"/>
                                </span>
                            </div>
                        </div>
                    </form>
                    <div v-if="imgAttached" style="display: flex; justify-content: space-between">
                        <span v-if="!pingingApi" @click="addPost"  class="api-button">Save</span>
                        <div class="api-button" v-else>
                            <span class="button-loader"></span>
                        </div>
                        <button @click="removeImage"  class="button">Remove</button>
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
        name: "AddPostModal",
        props: {
            profile: {},
        },
        data(){
            return{
                isSuccess: false,
                title: '',
                message: '',
                image: null,
                description: '',
                file: null,
                pingingApi: false,
                imgAttached: false,
            }
        },
        mounted(){

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
            addPost(){
                let img = this.image;
                this.pingingApi = true;
                let headers = {'Content-Type': 'multipart/form-data'};
                let data = new FormData();
                data.append('image', img);
                data.append('description', this.description);
                data.append('profile_id', this.profile.id);
                axios.post('/api/v1/post', data, headers)
                    .then(response => {
                        if(response.data.status_code === 201) {
                            this.$emit('imageUploaded', response.data);
                            this.$emit('closeConfirmation');
                        }
                        else{
                            this.openModal('Error!', response.data.message);
                        }
                        this.pingingApi = false;
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
    .post-upload-title{
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
        width: 400px;
        height: 400px;
        object-fit: contain;
    }
    post{
        width: 100%;
        margin: 20px 0;
    }
    .post-upload{
        height: 404px;
        width: 99%;
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
                color: #00A4FF;
                font-weight: 600;
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
            background: rgba(0, 0, 0, 0.1);
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
            background: #DFE1E6;
            width: 500px;
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
        border: none;
        font-weight: 600;
        background-color: #00A4FF;
        color: white;
        padding: 7px 14px;
        border-radius: 2px;
        outline: none;
        border: 0;
        text-transform: uppercase;
        cursor: pointer;
    }
</style>