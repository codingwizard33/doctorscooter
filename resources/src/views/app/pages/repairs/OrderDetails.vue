<template>
    <div class="main-content">
<!--        print content-->
        <vue-html2pdf
            :show-layout="false"
            :float-layout="true"
            :enable-download="false"
            :preview-modal="true"
            :paginate-elements-by-height="200"
            filename="Order Details"
            :pdf-quality="10"
            :manual-pagination="true"
            pdf-format="a7"
            pdf-orientation="landscape"
            pdf-content-width="380px"
            ref="html2Pdf"
        >
            <section slot="pdf-content">
                <!-- PDF Content Here -->
                <div class="main-content printing">
                        <div class="title">Order Detail</div>
                        <div class="content_data">
                            <div class="content_text">
                                <div class="text_item">Client Name: &nbsp;<span class="text_value">{{order_details.full_name}}</span></div>
                                <div class="text_item">Telephone: &nbsp;<span class="text_value">{{order_details.phone}}</span></div>
                                <div class="text_item">Model: &nbsp;<span class="text_value">{{order_details.model}}</span></div>
                            </div>
                            <div class="content_text code">
                                <div class="text_item">QR code:</div>
                                <div class="qr_url-container">
                                    <img :src="order_details.qr_url" alt="">
                                </div>
                            </div>
                        </div>

<!--                        <b-row>-->
<!--                            <b-col md="9" class="mb-2 mr-4">-->
<!--                                <b-card class="p-8">-->
<!--                                    <b-row>-->
<!--                                        <b-col md="5" class="detail_item">-->
<!--                                            <div class="detail_item-card">-->
<!--                                                <div class="detail_item-btn">Salesman</div>-->
<!--                                                <div class="detail_item-text">-->
<!--                                                    <div class="detail_item-name">Name: &nbsp;</div>-->
<!--                                                    <div class="detail_item-value">{{order_details.sales_man.firstname}} {{order_details.sales_man.lastname}}</div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </b-col>-->
<!--                                        <b-col md="6" class="detail_item">-->
<!--                                            <div class="detail_item-card">-->
<!--                                                <div class="detail_item-btn">Technician</div>-->
<!--                                                <div class="detail_item-text">-->
<!--                                                    <div class="detail_item-name">Name: &nbsp;</div>-->
<!--                                                    <div class="detail_item-value">{{order_details.full_name}}</div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </b-col>-->
<!--                                    </b-row>-->
<!--                                    <hr>-->
<!--                                    <b-row>-->
<!--                                        <b-col md="5" class="detail_item">-->
<!--                                            <div class="detail_item-card">-->
<!--                                                <div class="detail_item-btn">Customer Details</div>-->
<!--                                                <div class="detail_item-text">-->
<!--                                                    <div class="detail_item-name">Full Name: &nbsp;</div>-->
<!--                                                    <div class="detail_item-value">{{order_details.full_name}}</div>-->
<!--                                                </div>-->
<!--                                                <div class="detail_item-text">-->
<!--                                                    <div class="detail_item-name">Mobile: &nbsp;</div>-->
<!--                                                    <div class="detail_item-value">{{order_details.phone}}</div>-->
<!--                                                </div>-->
<!--                                                <div class="detail_item-text">-->
<!--                                                    <div class="detail_item-name">Email: &nbsp;</div>-->
<!--                                                    <div class="detail_item-value">{{order_details.email}}</div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </b-col>-->
<!--                                        <b-col md="6" class="detail_item">-->
<!--                                            <div class="detail_item-card">-->
<!--                                                <div class="detail_item-btn">Vehicle Details</div>-->
<!--                                                <div class="detail_item-text">-->
<!--                                                    <div class="detail_item-name">Model: &nbsp;</div>-->
<!--                                                    <div class="detail_item-value">{{order_details.model}}</div>-->
<!--                                                </div>-->
<!--                                                <div class="detail_item-text">-->
<!--                                                    <div class="detail_item-name">Service: &nbsp;</div>-->
<!--                                                    <div class="detail_item-value">Oil/Filter changed, Brake Work</div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </b-col>-->
<!--                                        <b-col md="1"></b-col>-->
<!--                                    </b-row>-->
<!--                                    <hr>-->
<!--                                    <b-row>-->
<!--                                        <b-col md="5" class="detail_item">-->
<!--                                            <div class="detail_item-card">-->
<!--                                                <div class="detail_item-btn">Issue Information</div>-->
<!--                                                <div class="detail_item-text">-->
<!--                                        <textarea-->
<!--                                            rows="5"-->
<!--                                            disabled-->
<!--                                            :placeholder="$t('Afewwords')"-->
<!--                                            v-model="order_details.information"-->
<!--                                        ></textarea>-->
<!--                                                </div>-->
<!--                                                <div class="detail_item-text">-->
<!--                                                    <div class="detail_item-name">Pictures of the Issues: &nbsp;</div>-->
<!--                                                    <div class="img_container" v-for="item of order_details.images">-->
<!--                                                        <img :src="item.path" alt="">-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </b-col>-->
<!--                                        <b-col md="6" class="detail_item">-->
<!--                                            <div class="detail_item-card">-->
<!--                                                <div class="detail_item-btn">Comments & Images By Technician</div>-->
<!--                                                <div class="detail_item-text">-->
<!--                                        <textarea-->
<!--                                            rows="5"-->
<!--                                            :placeholder="$t('Afewwords')"-->
<!--                                            v-model="order_details.text"-->
<!--                                        ></textarea>-->
<!--                                                </div>-->
<!--                                                <div class="detail_item-text">-->

<!--                                                    <div v-for="item of images" class="upload_img">-->
<!--                                                        <img :src="item" alt="">-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </b-col>-->
<!--                                        <b-col md="1"></b-col>-->
<!--                                    </b-row>-->
<!--                                    <b-row>-->

<!--                                    </b-row>-->
<!--                                </b-card>-->
<!--                            </b-col>-->
<!--                            <b-col md="2" class="detail_item print">-->
<!--                                <div class="qr_url-container">-->
<!--                                    <img :src="order_details.qr_url" alt="">-->
<!--                                </div>-->
<!--                            </b-col>-->

<!--                        </b-row>-->


                </div>
            </section>
        </vue-html2pdf>

        <div class="head_btn-container">
            <b-form-select
                v-model="order_details.status"
                @change="onChangeStatus"
                :class="[{'done': order_details.status == 'done'},
                 {'progress': order_details.status == 'pending'},
                 {'cancelled': order_details.status == 'cancelled'},
                 {'collection': order_details.status == 'waiting_for_collection'},
                 {'parts': order_details.status == 'waiting_for_parts'}
                 ]">
                <b-form-select-option value="done">Done</b-form-select-option>
                <b-form-select-option value="pending">In Progress</b-form-select-option>
                <b-form-select-option value="cancelled">Cancelled</b-form-select-option>
                <b-form-select-option value="waiting_for_parts">Waiting for Parts</b-form-select-option>
                <b-form-select-option value="waiting_for_collection">Waiting for Collection</b-form-select-option>
            </b-form-select>
            <div class="back_btn" @click="goBack()"><i class="nav-icon i-Left"></i>&nbsp; Back</div>
        </div>
        <breadcumb :page="$t('Order_Detail')" :folder="$t('Order_Detail')"/>
        <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>
        <div v-else>
            <b-row>
                <b-col md="8" class="mb-2 mr-4">
                    <b-card class="p-8">
                        <b-row>
                            <b-col md="12" class="mb-3">
                                <div class="order_details-date">
                                    <b>Created at: {{getDate(order_details.created_at)}}</b>
                                    <b>Updated at: {{getDate(order_details.updated_at)}}</b>

                                </div>
                            </b-col>
                        </b-row>
                        <b-row>
                            <b-col md="5" class="detail_item">
                                <div class="detail_item-card">
                                    <div class="detail_item-btn">Salesman</div>
                                    <div class="detail_item-text">
                                        <div class="detail_item-name">Name: &nbsp;</div>
                                        <div class="detail_item-value">{{order_details.sales_man.firstname}} {{order_details.sales_man.lastname}}</div>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="6" class="detail_item">
                                <div class="detail_item-card">
                                    <div class="detail_item-btn">Technician</div>
                                    <div class="detail_item-text">
                                        <div class="detail_item-name">Name: &nbsp;</div>
                                        <div class="detail_item-value">{{order_details.technician.firstname}} {{order_details.technician.lastname}}</div>
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
                                    <div class="detail_item-btn">Customer Details</div>
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
                                    <div class="detail_item-btn">Vehicle Details</div>
                                    <div class="detail_item-text">
                                        <div class="detail_item-name">Model: &nbsp;</div>
                                        <div class="detail_item-value">{{order_details.model}}</div>
                                    </div>
                                    <div class="detail_item-text">
                                        <div class="detail_item-name">Service: &nbsp;</div>
                                        <div class="detail_item-value">{{getServiceName(order_details.service)}}</div>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="1"></b-col>
                        </b-row>
                        <hr>
                        <b-row>
                            <b-col md="5" class="detail_item">
                                <div class="detail_item-card">
                                    <div class="detail_item-btn">Issue Information</div>
                                    <div class="detail_item-text">
                                        <textarea
                                            rows="5"
                                            disabled
                                            :placeholder="$t('Afewwords')"
                                            v-model="order_details.information"
                                        ></textarea>
                                    </div>
                                    <div class="detail_item-text">
                                        <div class="detail_item-name">Pictures of the Issues: &nbsp;</div>
                                        <div class="img_container" v-for="item of order_details.images">
                                            <img :src="item.path" alt="">
                                        </div>
                                    </div>
                                </div>
                            </b-col>
                            <b-col md="6" class="detail_item">
                                <div class="detail_item-card">
                                    <div class="detail_item-btn">Comments & Images By Technician</div>
                                    <div class="detail_item-text">
                                        <textarea
                                            rows="5"
                                            :placeholder="$t('Afewwords')"
                                            v-model="order_details.details.text"
                                        ></textarea>
                                    </div>
                                    <div class="detail_item-text">
                                        <div class="input_container" @click="addImg()">
                                            <input type="file" multiple ref="photo_upload" @change="onFileChange">
                                            <div class="up_img"></div>
                                            <div class="up_text">Upload from Photos</div>
                                        </div>
                                        <div v-for="item of order_details.details.images" class="upload_img">
                                            <img :src="'https://doctorscootercrm.co.uk/'+item.path" alt="">
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
                                <b-button class="save_btn" @click="saveOrderDetails()">Save</b-button>
                            </b-col>
                        </b-row>
                    </b-card>
                </b-col>
                <b-col md="3" class="detail_tab mb-2">
                    <div class="detail_tab-title mb-2">Order Status</div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Services</span>
                        <span class="all_done-btn" @click="allServiceDone(order_details.service)">All Done</span>
                    </div>
                    <div v-if="service.sub_service.length" class="detail_tab-status service" v-for="service of order_details.service">
                        <div class="detail_tab-service" v-for="item of service.sub_service">
                            <div class="detail_tab-status_name">{{item.subservice_name}}</div>
                            <b-form-select v-model="item.status" @change="onChangeService($event, item)" :class="{'done': item.status == 'done', 'pending': item.status == 'pending'}">
                                <b-form-select-option value="done">Done</b-form-select-option>
                                <b-form-select-option value="pending">Pending</b-form-select-option>
                            </b-form-select>
                        </div>
                    </div>
                    <div v-else class="detail_tab-status service" v-for="service of order_details.service">
                        <div class="detail_tab-service">
                            <div class="detail_tab-status_name">{{service.service_name}}</div>
                            <b-form-select v-model="service.status" :class="{'done': service.status == 'done', 'pending': service.status == 'pending'}">
                                <b-form-select-option value="done">Done</b-form-select-option>
                                <b-form-select-option value="pending">Pending</b-form-select-option>
                            </b-form-select>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Custom Services</span>
                        <span class="all_done-btn" @click="allCustomServiceDone()">All Done</span>
                    </div>
                    <div class="detail_tab-status" v-for="service of order_details.custom_service">
                        <div class="detail_tab-status_name">{{service.name}}</div>
                        <b-form-select v-model="service.status" @change="onCustomServiceChange($event, service)" :class="{'done': service.status == 'done', 'pending': service.status == 'pending'}">
                            <b-form-select-option value="done">Done</b-form-select-option>
                            <b-form-select-option value="pending">Pending</b-form-select-option>
                        </b-form-select>
                    </div>
                    <hr>
                    <div class="detail_tab-status">
                        <div class="detail_tab-status_name">Payment Status</div>
                        <b-form-select v-model="order_details.payment_status" @change="onChangePaymentStatus" :class="[
                            {'done': order_details.payment_status == 'paid'},
                            {'pending': order_details.payment_status == 'not_paid'},
                            {'pending': order_details.payment_status == 'pending'},
                            {'pending': order_details.payment_status == 'cancelled'}
                            ]">
                            <b-form-select-option value="paid">Paid</b-form-select-option>
                            <b-form-select-option value="not_paid">Not Paid</b-form-select-option>
                            <b-form-select-option value="pending">Pending</b-form-select-option>
                            <b-form-select-option value="cancelled">Cancelled </b-form-select-option>
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
    import VueHtml2pdf from 'vue-html2pdf'
    import * as html2canvas from 'html2canvas';

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
        components: {
            VueHtml2pdf

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
            getDate(date) {
                let d = new Date(date).toLocaleString()
                return d
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
            getServiceName(services) {
                let serviceNames = []
                services.map((service) => {
                    serviceNames.push(service.service_name)
                })
                return serviceNames.join(', ')
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
            onChangeService(ev, item) {
                NProgress.start();
                NProgress.set(0.1);
                axios
                    .post(
                        `sub/service/change-status`, {
                            subservice_id: item.id,
                            service_id: item.service_id,
                            order_id: this.getId,
                            status: ev,
                        }
                    )
                    .then(response => {
                        this.isLoading = false;
                        NProgress.done();
                        this.getDetails(this.getId)
                    })
                    .catch(error => {
                        NProgress.done();
                        setTimeout(() => {
                            this.isLoading = false;
                        }, 500);
                    })

            },
            onCustomServiceChange(ev, item) {
                console.log(ev, item, 'ggggggggg')
                NProgress.start();
                NProgress.set(0.1);
                axios
                    .post(
                        `custom/service/change-status-custom`, {
                            custom_service_id: item.id,
                            status: ev,
                        }
                    )
                    .then(response => {
                        this.isLoading = false;
                        NProgress.done();
                        this.getDetails(this.getId)
                    })
                    .catch(error => {
                        NProgress.done();
                        setTimeout(() => {
                            this.isLoading = false;
                        }, 500);
                    })
            },
            allServiceDone(services) {
                let arr = []
                services.map(item => {
                    arr.push(item.id)
                })
                NProgress.start();
                NProgress.set(0.1);
                axios
                    .post(
                        `sub/service/all-done`, {
                            order_id: this.getId,
                            service_id: arr,
                        }
                    )
                    .then(response => {
                        this.isLoading = false;
                        NProgress.done();
                        this.getDetails(this.getId)
                    })
                    .catch(error => {
                        NProgress.done();
                        setTimeout(() => {
                            this.isLoading = false;
                        }, 500);
                    })

            },
            allCustomServiceDone() {
                NProgress.start();
                NProgress.set(0.1);
                axios
                    .post(
                        `custom/service/all-done-custom`, {
                            order_id: this.getId,
                        }
                    )
                    .then(response => {
                        this.isLoading = false;
                        NProgress.done();
                        this.getDetails(this.getId)
                    })
                    .catch(error => {
                        NProgress.done();
                        setTimeout(() => {
                            this.isLoading = false;
                        }, 500);
                    })
            },
            onChangePaymentStatus(ev) {
                NProgress.start();
                NProgress.set(0.1);
                axios
                    .post(
                        `reaper/order/change/status/${this.getId}`, {
                            payment_status: ev,
                        }
                    )
                    .then(response => {
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
            onChangeStatus(ev) {
                NProgress.start();
                NProgress.set(0.1);
                axios
                    .post(
                        `reaper/order/change/status/${this.getId}`, {
                            status: ev
                        }
                    )
                    .then(response => {
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
            createImage(file) {
                var reader = new FileReader()
                reader.onload = event => {
                    this.images.push(event.target.result)
                }
                reader.readAsDataURL(file)
            },
            saveOrderDetails() {
                if(this.order_details.details.text && this.images.length) {
                    NProgress.start();
                        NProgress.set(0.1);
                        axios
                            .post(
                                `reaper/order/details/store/${this.getId}`, {
                                    order_id: this.getId,
                                    text: this.order_details.details.text,
                                    images: this.images
                                }
                            )
                            .then(response => {
                                this.isLoading = false;
                                NProgress.done();
                            })
                            .catch(error => {
                                NProgress.done();
                                setTimeout(() => {
                                    this.isLoading = false;
                                }, 500);
                            })
                }
            },
            generateReport () {
                this.$refs.html2Pdf.generatePdf()
            },
            printDetails() {
                console.log(this.$refs.html2Pdf)
                this.$refs.html2Pdf.generatePdf()

                // html2pdf(document.getElementById('main_print'), {
                //     margin: 1,
                //     filename: "i-was-html.pdf",
                // });

                // this.html2pdf(this.$refs.html2Pdf, {
                //     margin: 1,
                //     filename: 'document.pdf',
                //     image: { type: 'jpeg', quality: 0.98 },
                //     html2canvas: { dpi: 192, letterRendering: true },
                //     jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
                // })

                // const options = {
                //     filename: 'example.pdf',
                //     image: { type: 'jpeg', quality: 0.98 },
                //     html2canvas: { scale: 2 },
                //     jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
                // }
                // const content = this.$refs['html2Pdf']
                // VueHtml2pdf(content, options)

                // const printableContent = document.getElementById('main_print')
                // const printWindow = window.open('', '', 'height=1000,width=1000')
                // printWindow.document.write(printableContent.innerHTML)
                // printWindow.print()


                    // const htmlContent = document.getElementById("main_print").outerHTML;
                    // const iFrame = document.createElement("iframe");
                    // iFrame.style.display = "none";
                    // document.body.appendChild(iFrame);
                    //
                    // const pdfBlob = await new Promise((resolve) => {
                    //     iFrame.onload = () => {
                    //         const iFrameWindow = iFrame.contentWindow;
                    //         iFrameWindow.print();
                    //         iFrameWindow.addEventListener("afterprint", () => {
                    //             const pdfBlob = iFrameWindow.Blob;
                    //             resolve(pdfBlob);
                    //             document.body.removeChild(iFrame);
                    //         }, { once: true });
                    //     };
                    //     iFrame.srcdoc = htmlContent;
                    // });
                    // const downloadLink = document.createElement("a");
                    // downloadLink.href = URL.createObjectURL(pdfBlob);
                    // downloadLink.download = "my-pdf-document.pdf";
                    // downloadLink.onclick = () => downloadLink.remove();
                    // document.body.appendChild(downloadLink);
                    // downloadLink.click();


                // const printableContent =  `<img src="${props.row.qr_url}">`
                // const printWindow = window.open('', '', 'height=900,width=900')
                // setTimeout(() => {
                //     printWindow.document.write(printableContent.innerHtml)
                //     printWindow.print()
                // }, 300)

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
        & .order_details-date {
            display: flex;
            justify-content: space-between;
        }
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
                    color: #A958FC;
                    background: url("/images/purple_arrow_down.svg");
                    background-repeat: no-repeat;
                    background-position: right;
                    background-position-x: 90%;
                    background-color: rgba(169, 88, 252, 0.2);
                    position: relative;
                }
                &.cancelled {
                    width: 90px;
                    color: #F00;
                    background: url("/images/red_arrow_down.svg");
                    background-repeat: no-repeat;
                    background-position: right;
                    background-position-x: 90%;
                    background-color: rgba(255, 0, 0, 0.2);
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
        &.printing {
            padding: 16px;
            display: flex;
            flex-direction: column;
            width: 100%;
            & .title {
                color: #000;
                font-family: "Nunito", sans-serif;
                font-size: 12px;
                font-style: normal;
                font-weight: 600;
                line-height: 18px;
                padding-bottom: 8px;
            }
            & .content {
                &_data {
                    display: flex;
                    justify-content: space-between;
                }
                &_text {
                    display: flex;
                    flex-direction: column;
                    &.code {
                        width: 150px;
                        & .text_item {
                            padding: 0 10px;
                        }
                    }
                    & .text_item {
                        padding: 8px 0;
                        color: #949494;
                        font-family: "Nunito", sans-serif;
                        font-size: 10px;
                        font-style: normal;
                        font-weight: 500;
                        line-height: 15px;
                        & .text_value {
                            color:  #000000;
                            font-family: "Nunito", sans-serif;
                            font-size: 10px;
                            font-style: normal;
                            font-weight: 600;
                            line-height: 15px;
                        }
                    }
                    & .qr_url-container {
                        width: 122px;
                        height: 122px;
                        & img {
                            width: 122px;
                            height: 122px;
                        }
                    }
                }
            }
        }
    }
    ::v-deep .detail {
        &_item {
            &-btn {
                height: 35px;
                padding: 6px 18px;
                border-radius: 45px;
                background: rgba(255, 153, 0, 0.20) !important;
                border: none;
                color: #FF9900 !important;
                display: initial;
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
                    height: 45px;
                    border-radius: 4px;
                    margin: 0 3px;
                    img {
                        width: 55px;
                        height: 45px;
                    }

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
             .print_btn {
                width: 40px !important;
                height: 40px !important;
                border-radius: 6px;
                background: #F90 !important;
                border: none;
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
        &_tab {
            border-radius: 8px;
            background: #F6F6F6;
            padding: 22px;
            & .all_done-btn {
                text-decoration: underline;
                color: #309600;
                font-size: 15px;
                font-weight: 500;
                cursor: pointer;
            }
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
                padding: 8px 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
                &.service {
                    flex-direction: column;

                }

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
                        width: 95px;
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
                    font-size: 16px;
                    font-family: "Nunito", sans-serif;
                    font-weight: 600;
                    line-height: 22px;
                }
            }
            &-service {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 8px 0;
                width: 100%;
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
                    width: 80px;
                    background: url("/images/orange_arrow_down.svg");
                    background-color: rgba(252, 205, 136, 0.99);
                    background-repeat: no-repeat;
                    background-position: right;
                    background-position-x: 82%;
                    position: relative;
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
                        width: 95px;
                        color: #FF9900;
                        background: url("/images/orange_arrow_down.svg");
                        background-repeat: no-repeat;
                        background-position: right;
                        background-position-x: 82%;
                        background-color: rgba(255, 153, 0, 0.20);
                        position: relative;
                    }
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
