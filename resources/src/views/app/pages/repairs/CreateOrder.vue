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
                            <b-col md="12">
                                <div class="d-flex">
                                    <div class="today_date"><span class="date_name">Date: </span> &nbsp;{{getDate}}</div>
                                    <div class="today_date">
                                        <span class="date_name">Serial Number:  </span>
                                        <validation-provider
                                            name="SerialNumber"
                                            :rules="{required:true , min:3 , max:55}"
                                            v-slot="validationContext"
                                        >
                                            <b-form-group>
                                                <b-form-input
                                                    :state="getValidationState(validationContext)"
                                                    aria-describedby="Serial-feedback"
                                                    type="number"
                                                    :placeholder="$t('Enter_Your_Serial_Number')"
                                                    v-model="order.serial_number"
                                                ></b-form-input>
                                                <b-form-invalid-feedback id="Serial-feedback">
                                                    {{ validationContext.errors[0] }}
                                                </b-form-invalid-feedback>
                                            </b-form-group>
                                        </validation-provider>
                                    </div>
                                </div>
                                <hr />
                            </b-col>
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
                                        :custom-label="serviceType"
                                        label="name"
                                        track-by="name"
                                        :options="custom_services_options"
                                        :multiple="true"
                                        :taggable="true"
                                    >
                                    </multiselect>
                                </div>
                            </b-col>
                            <b-col md="12">
                                <b-button class="add_new-service" id="service_btn" @click="serviceModal()">
                                    <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1_2881)">
                                            <path d="M8 0.5C3.58853 0.5 0 4.08853 0 8.5C0 12.9115 3.58853 16.5 8 16.5C12.4115 16.5 16 12.9108 16 8.5C16 4.08916 12.4115 0.5 8 0.5ZM8 15.2607C4.27266 15.2607 1.23934 12.228 1.23934 8.5C1.23934 4.77203 4.27266 1.73934 8 1.73934C11.7273 1.73934 14.7607 4.77203 14.7607 8.5C14.7607 12.228 11.728 15.2607 8 15.2607Z" fill="white"/>
                                            <path d="M11.0984 7.82457H8.61973V5.34588C8.61973 5.00382 8.34273 4.7262 8.00004 4.7262C7.65736 4.7262 7.38036 5.00382 7.38036 5.34588V7.82457H4.90167C4.55898 7.82457 4.28198 8.1022 4.28198 8.44426C4.28198 8.78632 4.55898 9.06395 4.90167 9.06395H7.38036V11.5426C7.38036 11.8847 7.65736 12.1623 8.00004 12.1623C8.34273 12.1623 8.61973 11.8847 8.61973 11.5426V9.06395H11.0984C11.4411 9.06395 11.7181 8.78632 11.7181 8.44426C11.7181 8.1022 11.4411 7.82457 11.0984 7.82457Z" fill="white"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1_2881">
                                                <rect width="16" height="16" fill="white" transform="translate(0 0.5)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>&nbsp;
                                    Add New Service</b-button>
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
                                            <div class="upload_text">Upload from Camera</div>
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
                            <b-col md="12">
                                <h4 class="page_subtitle">Payment Comment</h4>
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
                            <b-col md="12">
                                <h4 class="page_subtitle">Select Payment Option</h4>
                                <b-form-group class="mx-1" v-slot="{ ariaDescribedby }">
                                    <b-form-radio-group
                                        v-model="order.selectedPayment"
                                        :options="paymentOptions"
                                        :aria-describedby="ariaDescribedby"
                                        name="radio-inline"
                                    ></b-form-radio-group>
                                </b-form-group>
                            </b-col>
                            <hr>
                            <b-col md="12">
                                <h4 class="page_subtitle">Do you have Warranty?</h4>
                                <b-form-group class="mx-1" v-slot="{ ariaDescribedby }">
                                    <b-form-checkbox-group
                                        v-model="order.selectedWarranty"
                                        :options="warrantyOptions"
                                        :aria-describedby="ariaDescribedby"
                                        name="flavour-1"
                                    ></b-form-checkbox-group>
                                </b-form-group>
                            </b-col>
                            <hr>
                            <b-col md="12">
                                <h4 class="page_subtitle">Payment Status</h4>
                                <b-form-group class="mx-1" v-slot="{ ariaDescribedby }">
                                    <b-form-radio-group
                                        v-model="order.payment_status"
                                        :options="paymentStatus"
                                        :aria-describedby="ariaDescribedby"
                                        name="radio-inline"
                                    ></b-form-radio-group>
                                </b-form-group>
                            </b-col>
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

    <!--change password modal-->
    <b-modal ref="add_service-modal" centered size="md" hide-header hide-footer>
        <div class="modal_content">
            <div class="modal_title">
                Add Service
            </div>
            <form @submit.prevent="addNewService()">

                <div class="modal_input">
                    <div class="input_item">
                        <label>Enter Service Name</label>
                        <b-form-input
                            v-model="new_service.name"
                            trim
                        ></b-form-input>
                        <div class="service_icon"></div>

                    </div>
                    <div class="input_item">
                        <label>Enter Amount</label>
                        <b-form-input
                            v-model="new_service.amount"
                            type="number"
                            trim
                        ></b-form-input>
                        <div class="amount_icon"></div>
                    </div>
                </div>
                <div class="modal_btn">
                    <b-button class="cancel_btn mx-2" @click="serviceModal()">Cancel</b-button>
                    <b-button class="change_btn mx-2" type="submit">Save</b-button>
                </div>
            </form>
        </div>
    </b-modal>
    <!--change password modal-->

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
                    serial_number: "",
                    payment_status: [],
                    services: [],
                    custom_services: [],
                    selectedPayment: [],
                    selectedWarranty: [],
                },
                new_service: {
                    id: null,
                    name: null,
                    amount: null
                },
                services_options: [
                    { name: 'Oil/Filter changed', code: 'of' },
                    { name: 'Break Work', code: 'bw' },
                    { name: 'Suspension', code: 'su' }
                ],
                custom_services_options: [],
                paymentOptions: [
                    { text: 'Full Payment', value: 'full' },
                    { text: 'Partial Payment', value: 'partial' },
                    { text: 'Deposit', value: 'deposit' }
                ],
                paymentStatus: [
                    { text: 'Paid', value: 'paid' },
                    { text: 'Not Paid', value: 'not_paid' },
                ],
                warrantyOptions: [
                    { text: 'Warranty', value: 'warranty' },
                    { text: 'Membership (10% Discount)   ', value: 'membership' }
                ],
                uploadFiles: [],
                images: []
            }
        },
        created() {
            this.getAllServices()
        },
        computed: {
            getDate() {
                let date = new Date()
                return date.toLocaleString("en-US", {day: "numeric", month: "long", year: "numeric",})
            }
        },
        methods: {
            serviceType({name, amount}) {
              return  `${name} - ($${amount})`
            },
            Submit_Order() {
                console.log('order')
               axios
                   .post("/reaper/order/store", {
                       full_name: this.order.full_name,
                       phone: this.order.mobile,
                       email: this.order.email,
                       model: this.order.model,
                       price: 40,
                       serial_number: this.order.serial_number,
                       information: this.order.information,
                       payment_comment: this.order.payment_comment,
                       payment_option: this.order.selectedPayment[0],
                       payment_status: this.order.payment_status,
                       payment_warranty: 'waranty',
                       images: this.images,
                       services: [
                           {
                               id: null,
                               service_id: 1
                           }
                       ],
                       custom_services: this.order.custom_services
                   })
               .then(response => {
                   console.log(response, 'response')
               })
               .catch(error => {
                   console.log(error)
               })

           },
            serviceModal() {
                this.new_service.name = null
                this.new_service.amount = null
                this.$refs['add_service-modal'].toggle('#service_btn')
            },
            addNewService() {
                if(this.new_service.name !== null && this.new_service.amount !== null ) {
                    this.custom_services_options.push({
                        id: null,
                        name: this.new_service.name,
                        amount: this.new_service.amount,
                    })
                    this.serviceModal()
                }
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
                this.uploadFiles.splice(index, 1)
            },
            getAllServices() {
                axios
                    .get("/service")
                    .then(response => {
                        console.log(response, 'response')
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        },

    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped lang="scss">
.page_title {
    padding: 0 15px 10px;
    font-weight: 500;
    font-size: 18px;
    line-height: 27px;
    color: #000000;
}
.page_subtitle {
    padding: 0;
    font-weight: 700;
    font-size: 13px;
    line-height: 20px;
    color: #000000;
}
     ::v-deep .order_content {
         & .today_date {
             font-weight: 700;
             font-size: 14px;
             line-height: 27px;
             color: #575757;
             margin-right: 40px;
             display: flex;
             align-items: center;
             & .form-group {
                 margin-bottom: 0;
                 margin-left: 20px;
             }

             & .date_name {
                 font-weight: 600;
                 font-size: 14px;
                 line-height: 27px;
                 color: #A5A5A5;
             }
         }
        & hr {
            width: 100%;
            margin-top: 1rem;
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
         & .add_new-service {
             background: #FF9900 !important;
             border-radius: 28px;
             border: none;
             font-weight: 700;
             font-size: 13px;
             line-height: 16px;
             color: #FFFFFF !important;
             display: flex;
             align-items: center;
             justify-content: center;
             &:focus {
                 box-shadow: none;
                 outline: none;
                 border: none;
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
::v-deep .modal-content {
    border-radius: 30px;
}
.modal {
    &_content {
        padding: 10px;
    }

    &_title {
        font-weight: 400;
        font-size: 28px;
        line-height: 39px;
        color: #5C5C5C;
    }

    &_input {
        padding: 25px 0;

        & .input_item {
            margin-bottom: 10px;
            position: relative;

            & label {
                font-weight: 400;
                font-size: 20px;
                line-height: 38px;
                color: #767676;
                margin-bottom: 0;
            }

            & input {
                height: 50px;
                border: 1.5px solid #AEB4C2;
                border-radius: 16px;
                padding-left: 50px;
                font-size: 18px;

                &:focus {
                    border: 1.5px solid #FF9900;
                    box-shadow: none;
                }
            }
            & .amount_icon {
                width: 28px;
                height: 28px;
                position: absolute;
                top: 50px;
                left: 13px;
                background: url('/images/amount.svg');
                background-position: center;
                background-repeat: no-repeat;
                background-size: contain;
            }
            & .service_icon {
                width: 28px;
                height: 28px;
                position: absolute;
                top: 50px;
                left: 13px;
                background: url('/images/screwdriver_wrench.svg');
                background-position: center;
                background-repeat: no-repeat;
                background-size: contain;
            }

        }
    }

    &_btn {
        display: flex;
        justify-content: flex-end;
        align-items: center;

        & .cancel_btn {
            border: 1.5px solid #FF9900;
            border-radius: 28px;
            padding: 8px 26px;
            background: #fff;
            color: #FF9900 !important;
            font-weight: 700;
            font-size: 16px;
            line-height: 16px;


            &:hover {
                filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
            }

            &:focus {
                border: 1.5px solid #FF9900;
                color: #FF9900;
            }
        }

        & .change_btn {
            background: #FF9900 !important;
            border-radius: 28px;
            padding: 8px 26px;
            border: none;
            color: #ffffff !important;
            font-weight: 700;
            font-size: 16px;
            line-height: 16px;

            &:hover {
                filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
            }

            &:focus {
                background: #FF9900;
                box-shadow: none;
            }

        }
    }

}
</style>
