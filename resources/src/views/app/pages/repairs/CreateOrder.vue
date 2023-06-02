<template>
<div class="main-content">
    <breadcumb :page="$t('Create_Repair_Order')" :folder="$t('Orders')"/>

    <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>
    <validation-observer ref="Create_Order" v-if="!isLoading">
        <b-form class="order_content" enctype="multipart/form-data">
            <b-row>
                <b-col md="8" class="mb-2">
                    <b-card>
                        <b-row>
                            <h1 class="page_title">Customer Details</h1>
                            <!-- Name -->
                            <b-col md="12" class="mb-2">

                                <validation-provider
                                    name="FullName"
                                    :rules="{required:true , min:3 , max:55}"
                                    v-slot="validationContext"
                                >
                                    <b-form-group :label="$t('Full_Name') + ' ' + '*'">
                                        <b-form-input
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="Name-feedback"
                                            label="Full Name"
                                            :placeholder="$t('Enter_Full_Name')"
                                            v-model="order.full_name"
                                        ></b-form-input>
                                        <b-form-invalid-feedback id="Name-feedback">{{ validationContext.errors[0]
                                            }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>

                                </validation-provider>

                            </b-col>
                            <!-- Mobile -->
                            <b-col md="12" class="mb-2">
                                <validation-provider
                                    name="Mobile"
                                    :rules="{required:true , min:3 , max:55}"
                                    v-slot="validationContext"
                                >
                                    <b-form-group :label="$t('Mobile') + ' ' + '*'">
                                        <b-form-input
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="Mobile-feedback"
                                            type="number"
                                            label="Mobile"
                                            :placeholder="$t('Enter_Your_Mobile_Number')"
                                            v-model="order.mobile"
                                        ></b-form-input>
                                        <b-form-invalid-feedback id="Mobile-feedback">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>

                                </validation-provider>
                            </b-col>
                            <!-- Email -->
                            <b-col md="12" class="mb-2">
                                <validation-provider
                                    name="Email"
                                    :rules="{required:true }"
                                    v-slot="validationContext"
                                >
                                    <b-form-group :label="$t('Email') + ' ' + '*'">
                                        <b-form-input
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="Email-feedback"
                                            label="Email"
                                            :placeholder="$t('Enter_Your_Email')"
                                            v-model="order.email"
                                        ></b-form-input>
                                        <b-form-invalid-feedback id="Email-feedback">
                                            {{ validationContext.errors[0] }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>

                                </validation-provider>
                            </b-col>
                            <hr>
                            <h1 class="page_title">Vehicle Details</h1>
                            <!--Model-->
                            <b-col md="12" class="mb-2">
                                <validation-provider
                                    name="Model"
                                    :rules="{required:true , min:3 , max:55}"
                                    v-slot="validationContext"
                                >
                                    <b-form-group :label="$t('Model') + ' ' + '*'">
                                        <b-form-input
                                            :state="getValidationState(validationContext)"
                                            aria-describedby="Model-feedback"
                                            label="Full Name"
                                            :placeholder="$t('Enter_Model')"
                                            v-model="order.model"
                                        ></b-form-input>
                                        <b-form-invalid-feedback id="Model-feedback">{{ validationContext.errors[0]
                                            }}
                                        </b-form-invalid-feedback>
                                    </b-form-group>

                                </validation-provider>
                            </b-col>
                            <b-col md="12" class="md-12">
                                <div class="multiselect_content">
                                    <label>Services</label>
                                    <multiselect
                                        v-model="order.services"
                                        :tag-placeholder="$t('Add_Tag')"
                                        :placeholder="$t('Search_Service')"
                                        label="name"
                                        track-by="code"
                                        :options="services_options"
                                        :multiple="true"
                                        :taggable="true"
                                        @tag="addTag">
                                    </multiselect>
                                </div>
                            </b-col>
                            <b-col md="12" class="md-12">
                                <div class="multiselect_content">
                                    <label>Custom Services (if any)</label>
                                    <multiselect
                                        v-model="order.custom_services"
                                        :tag-placeholder="$t('Add_Tag')"
                                        :placeholder="$t('Search_Custom_Service')"
                                        label="name"
                                        track-by="code"
                                        :options="custom_services_options"
                                        :multiple="true"
                                        :taggable="true"
                                        @tag="addTag">
                                    </multiselect>
                                </div>
                            </b-col>
                            <hr>
                            <h1 class="page_title">Issue information</h1>
                            <!--Issue-->
                            <b-col md="12" class="mb-2">
                                <b-form-group :label="$t('Enter_Your_Issue')">
                                        <textarea
                                            rows="6"
                                            class="form-control"
                                            :placeholder="$t('Afewwords')"
                                            v-model="order.information"
                                        ></textarea>
                                </b-form-group>
                            </b-col>
                            <!--Issue pictures-->
                            <b-col md="12" class="mb-2">
                                <label>Pictures of the Issue</label>
                                <div class="issue_images-content">
                                    <div class="issue_images-buttons">
                                        <div class="issue_images-btn" @click="uploadImg()">
                                            <div class="upload_icon"></div>
                                            <div class="upload_text">Upload Images from Device (PNG, JPG)</div>
                                            <input type="file" multiple ref="upload_image" @change="onFileChange">
                                        </div>
                                        <div class="issue_images-btn">
                                            <div class="camera_icon"></div>
                                            <div class="upload_text">Upload Images from Device (PNG, JPG)</div>
                                        </div>
                                    </div>
                                    <div class="issue_images-items">
                                        <div class="image_item"
                                             v-for="(image, index) of images"
                                             :key="index"
                                             :style="{ backgroundImage: 'url(' + image + ')' }"
                                        >
                                            <div class="x_btn" @click="removeImage(item, index)"></div>
                                        </div>
                                    </div>
                                </div>
                            </b-col>
                        </b-row>
                    </b-card>
                </b-col>
                <b-col md="5" class="mb-2 mt-4">
                    <b-card>
                        <b-row>
                            <h4 class="page_subtitle">Payment Comment</h4>
                            <b-col md="12" class="mb-2">
                                <b-form-group>
                                        <textarea
                                            rows="4"
                                            class="form-control"
                                            :placeholder="$t('Afewwords')"
                                            v-model="order.payment_comment"
                                        ></textarea>
                                </b-form-group>
                            </b-col>
                            <hr>
                            <b-col md="12">
                                <div class="payment_total">
                                    <div class="payment_total-text">Total amount:</div>
                                    <div class="payment_total-value">$40.00</div>
                                </div>
                            </b-col>
                            <hr>
                            <b-col >
                                <h4 class="page_subtitle">Payment Comment</h4>
                                <b-form-group class="mx-3" v-slot="{ ariaDescribedby }">
                                    <b-form-radio-group
                                        v-model="order.selectedPayment"
                                        :options="paymentOptions"
                                        :aria-describedby="ariaDescribedby"
                                        name="radio-inline"
                                    ></b-form-radio-group>
                                </b-form-group>
                            </b-col>
                            <hr>
                            <div >
                                <h4 class="page_subtitle">Do you have Warranty?</h4>
                                <b-form-group class="mx-3" v-slot="{ ariaDescribedby }">
                                    <b-form-checkbox-group
                                        v-model="order.selectedWarranty"
                                        :options="warrantyOptions"
                                        :aria-describedby="ariaDescribedby"
                                        name="flavour-1"
                                    ></b-form-checkbox-group>
                                </b-form-group>
                            </div>
                            <hr>
                            <b-col md="12">
                                <div class="payment_total due_amount">
                                    <div class="payment_total-text">Due amount:</div>
                                    <div class="payment_total-value">$40.00</div>
                                </div>
                            </b-col>
                            <b-col>
                                <div class="payment_buttons">
                                    <b-button class="cancel_btn">Cancel</b-button>
                                    <b-button class="pay_btn" @click="Submit_Order()">Pay Now</b-button>
<!--                                    @submit.prevent="Submit_Order"-->
                                </div>
                            </b-col>
                        </b-row>
                    </b-card>
                </b-col>
            </b-row>
        </b-form>
    </validation-observer>
</div>
</template>

<script>
    import $ from 'jquery'
    import VueTagsInput from "@johmun/vue-tags-input";
    import NProgress from "nprogress";
    export default {
        name: "CreateOrder",
        data() {
            return {
                order: {
                    full_name: "",
                    mobile : "",
                    email: "",
                    model: "",
                    information: "",
                    payment_comment: "",
                    services: [],
                    custom_services: [],
                    selectedPayment: [],
                    selectedWarranty: [],
                },
                services_options: [
                    { name: 'Oil/Filter changed', code: 'of' },
                    { name: 'Break Work', code: 'bw' },
                    { name: 'Suspension', code: 'su' }
                ],
                custom_services_options: [
                    { name: 'Car Wash', code: 'cw' },
                    { name: 'Oil Change', code: 'oc' },
                    { name: 'Breaks', code: 'b' }
                ],
                paymentOptions: [
                    { text: 'Full Payment', value: 'full' },
                    { text: 'Partial Payment', value: 'partial' },
                    { text: 'Deposit', value: 'deposit' }
                ],
                warrantyOptions: [
                    { text: 'Warranty', value: 'warranty' },
                    { text: 'Membership (10% Discount)   ', value: 'membership' }
                ],
                uploadFiles: [],
                images: []

            }
        },
        methods: {
            Submit_Order() {
               // var self = this;
               // console.log(self.order, 'gggggggg')
               // const token = '4|ESe2xmLq94ECUxQE9IjooZqLLYJg9s9p0lvjRs8J'
               // const config = {
               //     headers: { Authorization: `Bearer ${token}` }
               // };
               // let formData = new FormData()
               // formData.append('full_name', self.order.full_name)
               // formData.append('phone', self.order.mobile)
               // formData.append('email', self.order.email)
               // formData.append('model', self.order.model)
               // formData.append('price', 123)
               // formData.append('serial_number', 32423423)
               // formData.append('is_sold', true)
               // formData.append('images[]', self.uploadFiles)
               // formData.append('information', self.order.information)
               // formData.append('payment_comment', self.order.payment_comment)
               // formData.append('payment_option', self.order.selectedPayment[0])
               // formData.append('warranty', self.order.selectedWarranty)
               // axios
               //     .post("https://it5241.freelancedeveloper.site/api/0.3.3/admin/custom-products", formData, config)
               // .then(response => {
               //     console.log(response, 'aaaaaaaaaaaaaaaaaa')
               // })
               // .catch(error => {
               //     console.log(error)
               // })


               // const axios = require('axios');
               // const FormData = require('form-data');
               // const fs = require('fs');
               // let data = new FormData();
               // data.append('full_name', 'aaa');
               // data.append('phone', '11111');
               // data.append('email', 'asd@gmail.com');
               // data.append('model', 'asd');
               // data.append('price', '123');
               // data.append('serial_number', '32423423');
               // data.append('is_sold', 'true');
               // data.append('images[]', this.uploadFiles);
               // data.append('images[]', fs.createReadStream('/C:/Users/WPPC 0009/Desktop/test/watch/a2.jpg'));
               // data.append('images[]', fs.createReadStream('/C:/Users/WPPC 0009/Desktop/test/watch/a3.png'));
               // data.append('images[]', fs.createReadStream('/C:/Users/WPPC 0009/Desktop/test/watch/a4.jpg'));
               // data.append('information', '123');
               // data.append('payment_comment', '346');
               // data.append('payment_option', '5678');
               // data.append('warranty', '7809');

               // axios
               //     .post("https://it5241.freelancedeveloper.site/api/0.3.3/admin/custom-products", formData, config)
               // .then(response => {
               //     console.log(response, 'aaaaaaaaaaaaaaaaaa')
               // })
               // .catch(error => {
               //     console.log(error)
               // })

               // let url = 'https://5918.freelancedeveloper.site/api/run/payment';
               // return axios(url, {
               //     method: 'GET',
               //     mode: 'no-cors',
               //     headers: {
               //         'Access-Control-Allow-Origin': '*',
               //         'Content-Type': 'application/json',
               //     },
               // }).then(response => {
               //     console.log(response);
               // })
               // console.log(axios, 'axios')

               // axios.get('https://it5241.freelancedeveloper.site/api/0.3.3/test', {
               //     headers: {
               //         'Access-Control-Allow-Origin': '*',
               //     }
               // })
               //     .then(response => {
               //         console.log(response)
               //     })
               //     .catch(error => {
               //         console.log(error)
               //     })
                // const token = '4|ESe2xmLq94ECUxQE9IjooZqLLYJg9s9p0lvjRs8J'
                // const config = {
                //     headers: { Authorization: `Bearer ${token}` }
                // };

               // $.ajax({
               //     type: 'GET',
               //     url: "https://it5241.freelancedeveloper.site/api/0.3.3/admin/custom-products",
               //         headers: {
               //             'Access-Control-Allow-Origin': '*',
               //             'Authorization': `Bearer 11|Pj6ZX0LWqUHrhIhMdApVwVvg8Ha9VJRWQmr8GC4C`
               //         },
               //     success: function(result){
               //         console.log(result);
               //     }
               // });
                console.log('order')
           },

            //------ Validation State
            getValidationState({dirty, validated, valid = null}) {
                return dirty || validated ? valid : null;
            },
            addTag (newTag) {
                const tag = {
                    name: newTag,
                    code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                // this.options.push(tag)
                // this.value.push(tag)
            },
            uploadImg() {
                this.$refs.upload_image.click()
            },
            onFileChange(event) {
                this.uploadFiles = []
                for (let i = 0; i < event.target.files.length; i++) {
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
            removeImage(item, index) {
                this.images.splice(index, 1)
            }
        },

    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped lang="scss">
.page_title {
    padding: 0 15px 5px;
    font-weight: 500;
    font-size: 18px;
    line-height: 27px;
    color: #000000;
}
.page_subtitle {
    padding: 0 15px;
    font-weight: 700;
    font-size: 13px;
    line-height: 20px;
    color: #000000;
}
     ::v-deep .order_content {
        & hr {
            width: 100%;
        }
         & textarea {
             resize: none;
         }
         & input {
             height: 40px;
         }
         & .multiselect__tags {
             border: 1px solid #9CA3AF;
             padding: 0 40px 0 8px;
         }
         & .multiselect__tag {
             margin-top: 10px;
             margin-bottom: 2px;
             background: #FF9900;
         }
         & .multiselect__tag-icon {

             &:hover {
                 background: #c87800;
             }
             &:after {
                 color: #ffffff;
             }
         }
         & .multiselect__option--highlight {
             background: #FF9900;
             &:after {
                 background: #c87800;
             }
         }
         & .multiselect__placeholder {
             padding-top: 8px;
         }
         & .multiselect_content {
             padding-bottom: 16px;
             & label {

             }
         }
         & .issue_images {
             &-content {
                 width: 100%;
                 background: #FFFFFF;
                 border: 1px solid #AEB4C2;
                 border-radius: 8px;
                 padding: 25px 30px;
                 display: flex;
                 flex-direction: column;
             }
             &-buttons {
                 width: 100%;
                 display: flex;
                 align-items: center;
             }
             &-btn {
                 width: 350px;
                 height: 170px;
                 border: 1px solid #A7A7A7;
                 border-radius: 15px;
                 margin-right: 40px;
                 display: flex;
                 flex-direction: column;
                 justify-content: center;
                 align-items: center;
                 cursor: pointer;
                 & input {
                     width: 0;
                     height: 0;
                 }
                 & .upload_icon {
                     width: 39px;
                     height: 32px;
                     background: url("/images/upload.svg");
                     background-position: center;
                     background-repeat: no-repeat;
                     background-size: contain;
                 }
                 & .camera_icon {
                     width: 33px;
                     height: 28px;
                     background: url("/images/photo.svg");
                     background-position: center;
                     background-repeat: no-repeat;
                     background-size: contain;
                 }
                 & .upload {
                     &_icon {

                     }
                     &_text {
                         font-weight: 400;
                         font-size: 14.2px;
                         line-height: 21px;
                         color: #000000;
                         padding-top: 30px;
                     }
                 }
             }
             &-items {
                 padding-top: 20px;
                 display: flex;
                 flex-wrap: wrap;
                 & .image_item {
                     position: relative;
                     width: 110px;
                     height: 130px;
                     margin: 0 16px 10px 0;
                     border-radius: 10px;
                     background-position: center;
                     background-repeat: no-repeat;
                     background-size: cover;
                     & .x_btn {
                         position: absolute;
                         top: 8px;
                         right: 8px;
                         width: 14px;
                         height: 14px;
                         border-radius: 50%;
                         background: url("/images/x_btn.png") no-repeat center;
                         background-size: cover;
                         cursor: pointer;
                     }
                 }
             }
         }
         & .payment {
             &_total {
                 display: flex;
                 justify-content: space-between;
                 align-items: center;
                 &-text,
                 &-value {
                     font-weight: 500;
                     font-size: 14px;
                     line-height: 20px;
                     color: #000000;
                 }
                 &.due_amount {
                     & .payment_total-text,
                     & .payment_total-value {
                         font-weight: 700;
                         font-size: 16px;
                         line-height: 20px;
                         color: #000000;
                     }
                 }
             }
             &_buttons {
                 padding-top: 25px;
                 display: flex;
                 justify-content: flex-end;
                 & .cancel_btn {
                     display: flex;
                     align-items: center;
                     justify-content: center;
                     padding: 8px 20px;
                     width: 86px;
                     height: 33px;
                     background: #ffffff !important;
                     border-radius: 28px;
                     border: 1px solid #FF9900 !important;
                     color: #FF9900 !important;
                 }
                 & .pay_btn {
                     margin-left: 16px;
                     display: flex;
                     align-items: center;
                     justify-content: center;
                     padding: 8px 20px;
                     width: 86px;
                     height: 33px;
                     border-radius: 28px;
                     background-color: #FF9900 !important;
                     color: #ffffff !important;
                     border: none;
                 }
             }
         }
    }
    .form-control {
        background: transparent;
    }
input[type=number] {
    -moz-appearance: textfield !important;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none !important;
    margin: 0 !important;
}
</style>
