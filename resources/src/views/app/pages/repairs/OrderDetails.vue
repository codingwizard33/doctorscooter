<template>
    <div class="main-content">
        <div class="head_btn-container">
            <b-form-select
                v-model="order_details.status"
                :class="{'done': order_details.status == 'done',
                 'progress': order_details.status == 'progress',
                 'collection': order_details.status == 'collection',
                 'parts': order_details.status == 'parts',
                 }">
                <b-form-select-option value="done">Done</b-form-select-option>
                <b-form-select-option value="progress">In Progress</b-form-select-option>
                <b-form-select-option value="collection">Waiting for Collection</b-form-select-option>
                <b-form-select-option value="parts">Waiting for Parts</b-form-select-option>
            </b-form-select>
            <div class="back_btn" @click="goBack()"><i class="nav-icon i-Left"></i>&nbsp; Back</div>
        </div>


        <breadcumb :page="$t('Order_Detail')" :folder="$t('Order_Detail')"/>

        <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>
        <div v-else>
            <b-row>
                <b-col md="8" class="mb-2 mr-5">
                    <b-card>
                        <b-row>
                            <b-col md="5" class="detail_item">
                                <div class="detail_item-card">
                                    <b-button class="detail_item-btn">Salesman</b-button>
                                    <div class="detail_item-text">
                                        <div class="detail_item-name">Name: &nbsp;</div>
                                        <div class="detail_item-value">{{order_details.full_name}}</div>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="6" class="detail_item">
                                <div class="detail_item-card">
                                    <b-button class="detail_item-btn">Technician</b-button>
                                    <div class="detail_item-text">
                                        <div class="detail_item-name">Name: &nbsp;</div>
                                        <div class="detail_item-value">{{order_details.full_name}}</div>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="1" class="detail_item print">
                                <div class="print_btn" @click="printDetails()">
                                    <i class="btn_img"></i>
                                </div>
                            </b-col>
                        </b-row>
                        <hr>
                        <b-row>
                            <b-col md="5" class="detail_item">
                                <div class="detail_item-card">
                                    <b-button class="detail_item-btn">Customer Details</b-button>
                                    <div class="detail_item-text">
                                        <div class="detail_item-name">Full Name: &nbsp;</div>
                                        <div class="detail_item-value">{{order_details.full_name}}</div>
                                    </div>
                                    <div class="detail_item-text">
                                        <div class="detail_item-name">Mobile: &nbsp;</div>
                                        <div class="detail_item-value">{{order_details.phone}}</div>
                                    </div>
                                    <div class="detail_item-text">
                                        <div class="detail_item-name">Email: &nbsp;</div>
                                        <div class="detail_item-value">{{order_details.email}}</div>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="6" class="detail_item">
                                <div class="detail_item-card">
                                    <b-button class="detail_item-btn">Vehicle Details</b-button>
                                    <div class="detail_item-text">
                                        <div class="detail_item-name">Model: &nbsp;</div>
                                        <div class="detail_item-value">{{order_details.model}}</div>
                                    </div>
                                    <div class="detail_item-text">
                                        <div class="detail_item-name">Service: &nbsp;</div>
                                        <div class="detail_item-value">Oil/Filter changed, Brake Work</div>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="1"></b-col>
                        </b-row>
                        <hr>
                        <b-row>
                            <b-col md="5" class="detail_item">
                                <div class="detail_item-card">
                                    <b-button class="detail_item-btn">Issue Information</b-button>
                                    <div class="detail_item-text">
                                        <textarea
                                            rows="5"
                                            :placeholder="$t('Afewwords')"
                                            v-model="order_details.information"
                                        ></textarea>
                                    </div>
                                    <div class="detail_item-text">
                                        <div class="detail_item-name">Pictures of the Issues: &nbsp;</div>
                                        <div class="img_container" v-for="item of 6">
                                            <img :src="image" alt="">
                                        </div>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="6" class="detail_item">
                                <div class="detail_item-card">
                                    <b-button class="detail_item-btn">Comments & Images By Technician</b-button>
                                    <div class="detail_item-text">
                                        <textarea
                                            rows="5"
                                            :placeholder="$t('Afewwords')"
                                            v-model="order_details.payment_comment"
                                        ></textarea>
                                    </div>
                                    <div class="detail_item-text">
                                        <div class="input_container" @click="addImg()">
                                            <input type="file" multiple ref="photo_upload" @change="onFileChange">
                                            <div class="up_img"></div>
                                            <div class="up_text">Upload from Photos</div>
                                        </div>
                                        <div v-for="item of images" class="upload_img">
                                            <img :src="item" alt="">
                                        </div>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="1"></b-col>
                        </b-row>
                        <b-row>
                            <b-col md="12" class="save_btn-container">
                                <b-button class="save_btn">Save</b-button>
                            </b-col>
                        </b-row>
                    </b-card>
                </b-col>
                <b-col md="3" class="detail_tab mb-2">
                    <div class="detail_tab-title">Order Status</div>
                    <div class="detail_tab-status" v-for="service of order_details.service">
                        <div class="detail_tab-status_name">{{service.id}}</div>
                        <b-form-select v-model="service.status" :class="{'done': service.status == 'done', 'pending': service.status == 'pending'}">
                            <b-form-select-option value="done">Done</b-form-select-option>
                            <b-form-select-option value="pending">Pending</b-form-select-option>
                        </b-form-select>
                    </div>
                    <hr>
                    <div class="detail_tab-status" v-for="service of order_details.custom_service">
                        <div class="detail_tab-status_name">{{service.name}}</div>
                        <b-form-select v-model="service.status" :class="{'done': service.status == 'done', 'pending': service.status == 'pending'}">
                            <b-form-select-option value="done">Done</b-form-select-option>
                            <b-form-select-option value="pending">Pending</b-form-select-option>
                        </b-form-select>
                    </div>
                    <hr>
                    <div class="detail_tab-status">
                        <div class="detail_tab-status_name">Payment Status</div>
                        <b-form-select v-model="order_details.payment_status" :class="{'done': order_details.payment_status == 'done', 'pending': order_details.payment_status == 'pending'}">
                            <b-form-select-option value="done">Paid</b-form-select-option>
                            <b-form-select-option value="pending">Not Paid</b-form-select-option>
                        </b-form-select>
                    </div>

                </b-col>
            </b-row>

        </div>
    </div>
</template>

<script>
    import NProgress from "nprogress";
    import img1 from '../../../../../src/assets/images/photo-wide-5.jpeg'

    export default {
        name: "OrderDetails",
        data() {
            return {
                isLoading: true,
                order_details: {},
                selected: 'pending',
                image: img1,
                uploadFiles: [],
                images: []
                // options: [
                //     { value: 'Done', text: 'Done' },
                //     { value: 'Pending', text: 'Pending' },
                // ]

            }
        },
        computed: {
            getId() {
                return this.$route.params.id
            }
        },
        methods: {
            goBack() {
                this.$router.go(-1)
            },
            printDetails() {
                console.log('print details')
            },
            getDetails(id) {
                NProgress.start();
                NProgress.set(0.1);
                axios
                .get(
                    `reaper/order/show/${id}`
                )
                .then(response => {
                    this.order_details = response.data.product
                    console.log(response.data.product, 'res')
                    this.isLoading = false;
                    NProgress.done();
                })
                .catch(error => {
                    NProgress.done();
                    setTimeout(() => {
                        this.isLoading = false;
                    }, 500);
                })
            },
            addImg() {
                this.$refs.photo_upload.click()
            },
            onFileChange(event) {
                for(let i=0; i < event.target.files.length; i++) {
                    this.uploadFiles.push(event.target.files[i])
                    this.createImage(event.target.files[i])
                }

            },
            createImage(file) {
                var reader = new FileReader()
                reader.onload = event => {
                    this.images.push(event.target.result)
                }
                reader.readAsDataURL(file)
            },
        }, //end Methods
        //-----------------------------Created function-------------------

        created() {
            this.getDetails(this.getId)
            // console.log(this.$route.query, 'query')
        }
    }
</script>

<style scoped lang="scss">
    .main-content {
        position: relative;
        & .head_btn-container {
            position: absolute;
            top: 0;
            right: 0;
            display: flex;
            align-items: center;
            & select {
                margin-right: 30px;
                padding: 4px 16px;
                font-size: 11px;
                height: 35px;
                font-family: "Nunito", sans-serif;
                font-weight: 700;
                border-radius: 40px;
                border: none;
                display: flex;
                justify-content: center;
                align-items: center;
                &:focus {
                    box-shadow: none;
                }
                &.done {
                    width: 80px;
                    color: #309600;
                    background: url("/images/green_arrow_down.svg");
                    background-repeat: no-repeat;
                    background-position: right;
                    background-position-x: 82%;
                    background-color: #D6EACC;
                    position: relative;
                }
                &.progress {
                    width: 110px;
                    color: #FF9900;
                    background: url("/images/orange_arrow_down.svg");
                    background-repeat: no-repeat;
                    background-position: right;
                    background-position-x: 82%;
                    background-color: rgba(255, 153, 0, 0.20);
                    position: relative;
                }
                &.collection {
                    width: 170px;
                    color: #40D1FD;
                    background: url("/images/blue_arrow_down.svg");
                    background-repeat: no-repeat;
                    background-position: right;
                    background-position-x: 90%;
                    background-color: rgba(64, 209, 253, 0.20);
                    position: relative;
                }
                &.parts {
                    width: 140px;
                    color: #40D1FD;
                    background: url("/images/blue_arrow_down.svg");
                    background-repeat: no-repeat;
                    background-position: right;
                    background-position-x: 90%;
                    background-color: rgba(64, 209, 253, 0.20);
                    position: relative;
                }
            }
        }
        & .back_btn {
            cursor: pointer;
            font-weight: 600;
            font-size: 18px;
            line-height: 0;
            display: flex;
            align-items: center;
            & i {
                font-size: 24px;
                font-weight: 600;
            }
        }
    }
    ::v-deep .detail {
        &_item {
            &.print {
                position: relative;

                & .print_btn {
                    position: absolute;
                    top: 4px;
                    right: 20px;
                    width: 41px;
                    height: 41px;
                    border-radius: 6px;
                    background: #F90;
                    box-shadow: 0 4px 5px 0px rgba(0, 0, 0, 0.20);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    cursor: pointer;

                    & .btn_img {
                        width: 24px;
                        height: 24px;
                        background: url("/images/printer.svg");
                        background-position: center;
                        background-repeat: no-repeat;
                        background-size: contain;
                    }
                }
            }

            &-btn {
                height: 35px;
                padding: 6px 18px;
                border-radius: 45px;
                background: rgba(255, 153, 0, 0.20) !important;
                border: none;
                color: #FF9900 !important;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            &-text {
                display: flex;
                padding: 25px 0 0;
                flex-wrap: wrap;
                & textarea {
                    width: 100%;
                    border-radius: 10px;
                    border: 1px solid #BDBDBD;
                    padding: 15px 33px 15px 11px;
                    color: #535353;
                    font-size: 19px;
                    font-family: "Nunito", sans-serif;
                    line-height: 20px;
                    letter-spacing: 0.95px;
                    resize: none;
                    &::-webkit-scrollbar {
                        width: 6px;
                    }
                    &::-webkit-scrollbar-track {
                        border-radius: 10px;
                    }
                    &::-webkit-scrollbar-thumb {
                        background: grey;
                        border-radius: 10px;
                    }
                }
                & .img_container {
                    width: 55px;
                    height: 34px;
                    border-radius: 4px;
                    margin: 0 3px;

                }
                & .input_container {
                    width: 210px;
                    height: 100px;
                    border-radius: 11px;
                    border: 1px solid #BDBDBD;
                    background: #FFF;
                    position: relative;
                    margin-right: 10px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex-direction: column;
                    & .up_img {
                        width: 39px;
                        height: 32px;
                        background: url("/images/upload.svg");
                        background-repeat: no-repeat;
                        background-position: center;
                        background-size: contain;
                    }
                    & .up_text {
                        font-size: 19px;
                        font-family: "Nunito", sans-serif;
                        line-height: 11px;
                        color: #000;
                        padding: 16px 0;
                    }
                    & input {
                        position: absolute;
                        opacity: 0;
                        visibility: hidden;
                        width: 100%;
                        height: 100%;
                    }
                }
                & .upload_img {
                    width: 180px;
                    height: 100px;
                    border-radius: 11px;
                    margin: 0 10px 10px 0;
                    & img {
                        width: 100%;
                        height: 100%;
                        border-radius: 11px;
                    }
                }
            }

            &-name {
                color: #949494;
                font-size: 18px;
                font-family: "Nunito", sans-serif;
                font-weight: 500;
                line-height: 19.5px;
            }

            &-value {
                font-size: 18px;
                font-family: "Nunito", sans-serif;
                font-weight: 600;
                line-height: 19.5px;
                color: #000000;

            }

        }
        &_tab {
            border-radius: 8px;
            background: #F6F6F6;
            padding: 22px;
            & hr {
                margin-top: 15px;
                margin-bottom: 15px;
            }
            &-title {
                color: #414141;
                font-size: 25px;
                font-family: "Nunito", sans-serif;
                font-weight: 700;
                line-height: 36px;
            }
            &-status {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 14px 0;
                & select {
                    padding: 4px 16px;
                    font-size: 11px;
                    font-family: "Nunito", sans-serif;
                    font-weight: 700;
                    border-radius: 40px;
                    border: none;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    &:focus {
                        box-shadow: none;
                    }
                    &.done {
                        width: 80px;
                        color: #309600;
                        background: url("/images/green_arrow_down.svg");
                        background-repeat: no-repeat;
                        background-position: right;
                        background-position-x: 82%;
                        background-color: #D6EACC;
                        position: relative;
                    }
                    &.pending {
                        width: 90px;
                        color: #FF9900;
                        background: url("/images/orange_arrow_down.svg");
                        background-repeat: no-repeat;
                        background-position: right;
                        background-position-x: 82%;
                        background-color: rgba(255, 153, 0, 0.20);
                        position: relative;
                    }
                }
                &_name {
                    color: #0F0F0F;
                    font-size: 18px;
                    font-family: "Nunito", sans-serif;
                    font-weight: 500;
                    line-height: 29.5px;
                }
            }
        }
    }
    .save_btn {
        border: none;
        height: 35px;
        padding: 6px 32px;
        border-radius: 60px;
        background: #F90 !important;
        color: #FFF !important;
        display: flex;
        justify-content: center;
        align-items: center;
        &-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
    }
</style>
