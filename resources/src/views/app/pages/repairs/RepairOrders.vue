<template>
    <div class="main-content">
        <breadcumb :page="$t('Repair')" :folder="$t('Repair')"/>

        <div v-if="isLoading" class="loading_page spinner spinner-primary mr-3"></div>
        <div v-else>
            <vue-good-table
                mode="remote"
                :columns="columns"
                :totalRows="totalRows"
                :rows="orders"
                :sort-options="{
                    enabled: false,
                }"
                :search-options="{
                  enabled: true,
                  placeholder: $t('Search_this_table'),
                }"
                :row-style-class="rowStyleClassFn"
                @on-search="onSearch"
                styleClass="tableOne vgt-table"
            >
                <div slot="table-actions" class="mb-1 d-flex">
                    <b-button class="new_order-btn mx-3" @click="newOrder()">
                        <span class="d-flex"><i class="i-Add"></i></span>
                        <span class="ul-btn__text ml-1">{{$t('New')}}</span>
                    </b-button>
                    <b-button class="filter_btn" size="sm" v-b-toggle.sidebar-right-f>
                        <span class="d-flex"><i class="i-Filter-2"></i></span>
                        <span class="ul-btn__text ml-1">{{ $t("Filter") }}</span>
                    </b-button>
                </div>
                <template slot="table-row" slot-scope="props">
                    <span v-if="props.column.field == 'qr_url'">
                        <img :src="props.formattedRow[props.column.field]" alt="QR img" style="width: 85px; height: 70px">
<!--                        <div v-html="props.formattedRow[props.column.field]"></div>-->
                    </span>
<!--                    <span v-else-if="props.column.field == 'bar_code'">-->
<!--                        <div v-html="props.formattedRow[props.column.field]"></div>-->
<!--                    </span>-->
                    <span v-else-if="props.column.field == 'created_at'">
                        {{getDate(props.formattedRow[props.column.field])}}
                    </span>
                    <span v-else-if="props.column.field == 'updated_at'">
                        {{getDate(props.formattedRow[props.column.field])}}
                    </span>
                    <span v-else>
                      {{ props.formattedRow[props.column.field] }}
                    </span>

                    <div v-if="props.column.field == 'payment_status'">
                        {{ upper(props.formattedRow[props.column.field])}}
                    </div>
                    <div v-if="props.column.field == 'status'">
                        {{ upper(props.formattedRow[props.column.field])}}
                    </div>


                    <b-button v-if="props.column.field == 'action'" class="open_order-btn" @click="orderDetails(props)">
                        Open Order <span class="ml-2 d-flex"><i class="i-Arrow-Right"></i></span>
                    </b-button>
<!--                    <b-button v-if="props.column.field == 'print'" class="print_btn" @click="printQr(props)">-->
<!--&lt;!&ndash;                        <div class="btn_img"></div>&ndash;&gt;-->
<!--                        <div class="btn_img"></div>-->
<!--                    </b-button>-->
                </template>

            </vue-good-table>
            <!-- Multiple filter -->
            <b-sidebar id="sidebar-right-f" :title="$t('Filter')" bg-variant="white" right shadow>
                <div class="px-3 py-2">
                    <b-row>
                        <!-- Code Product  -->
<!--                        <b-col md="12">-->
<!--                            <b-form-group :label="$t('CodeProduct')">-->
<!--                                <b-form-input-->
<!--                                    label="Code Product"-->
<!--                                    :placeholder="$t('SearchByCode')"-->
<!--                                    v-model="Filter_code"-->
<!--                                ></b-form-input>-->
<!--                            </b-form-group>-->
<!--                        </b-col>-->

                        <!-- Name  -->
<!--                        <b-col md="12">-->
<!--                            <b-form-group :label="$t('ProductName')">-->
<!--                                <b-form-input-->
<!--                                    label="Name Product"-->
<!--                                    :placeholder="$t('SearchByName')"-->
<!--                                    v-model="Filter_name"-->
<!--                                ></b-form-input>-->
<!--                            </b-form-group>-->
<!--                        </b-col>-->

                        <!-- Category  -->
                        <b-col md="12">
                            <b-form-group :label="$t('Categorie')">
                                <v-select
                                    :placeholder="$t('Choose_Category')"
                                    v-model="Filter_category"
                                    :options="categories.map(categories => ({label: categories.lavel, value: categories.name}))"
                                />
                            </b-form-group>
                        </b-col>

                        <!-- Brand  -->
<!--                        <b-col md="12">-->
<!--                            <b-form-group :label="$t('Brand')">-->
<!--                                <v-select-->
<!--                                    :reduce="label => label.value"-->
<!--                                    :placeholder="$t('Choose_Brand')"-->
<!--                                    v-model="Filter_brand"-->
<!--                                    :options="brands.map(brands => ({label: brands.name, value: brands.id}))"-->
<!--                                />-->
<!--                            </b-form-group>-->
<!--                        </b-col>-->

<!--                        <b-col md="6" sm="12">-->
<!--                            <b-button-->
<!--                                @click="Get_Products(serverParams.page)"-->
<!--                                variant="primary m-1"-->
<!--                                size="sm"-->
<!--                                block-->
<!--                            >-->
<!--                                <i class="i-Filter-2"></i>-->
<!--                                {{ $t("Filter") }}-->
<!--                            </b-button>-->
<!--                        </b-col>-->

<!--                        <b-col md="6" sm="12">-->
<!--                            <b-button @click="Reset_Filter()" variant="danger m-1" size="sm" block>-->
<!--                                <i class="i-Power-2"></i>-->
<!--                                {{ $t("Reset") }}-->
<!--                            </b-button>-->
<!--                        </b-col>-->

                    </b-row>
                </div>
            </b-sidebar>
        </div>
    </div>
</template>

<script>
    import NProgress from "nprogress";

    export default {
        name: "RepairOrders",
        data() {
            return {
                totalRows: "",
                search: "",
                isLoading: true,
                orders: {},
                Filter_category: '',
                categories: [
                    {
                        label: 'Paid',
                        name: 'paid'
                    },
                    {
                        label: 'Not Paid',
                        name: 'not_paid'
                    },
                    {
                        label: 'Pending',
                        name: 'pending'
                    },
                    {
                        label: 'Cancelled',
                        name: 'cancelled'
                    }
                ]
            }
        },
        computed: {
            columns() {
                return [
                    {
                        label: this.$t("Reference"),
                        field: "qr_url",
                        tdClass: "text-left",
                        thClass: "text-left"
                    },
                    {
                        label: this.$t("CustomerName"),
                        field: "full_name",
                        tdClass: "text-left",
                        thClass: "text-left"
                    },
                    {
                        label: this.$t("Information"),
                        field: "information",
                        html: true,
                        tdClass: "text-left",
                        thClass: "text-left"
                    },
                    {
                        label: this.$t("PaymentStatus"),
                        field: "payment_status",
                        tdClass: this.tdClassPaymentStatus,
                        thClass: "text-left"
                    },
                    {
                        label: this.$t("Status"),
                        field: "status",
                        tdClass: this.tdClassStatus,
                        thClass: "text-left"
                    },
                    {
                        label: this.$t("CreatedAt"),
                        field: "created_at",
                        tdClass: "text-left",
                        thClass: "text-left"
                    },
                    {
                        label: this.$t("UpdatedAt"),
                        field: 'updated_at',
                        tdClass: "text-left",
                        thClass: "text-left"
                    },
                    {
                        label: '',
                        field: "action",
                        tdClass: "text-left",
                        thClass: "text-left"
                    },
                    // {
                    //     label: '',
                    //     field: "print",
                    //     tdClass: "text-left",
                    //     thClass: "text-left"
                    // },

                ];
            }
        },
        methods: {
            getOrders() {
                NProgress.start();
                NProgress.set(0.1);
                axios.get('/reaper/order')
                    .then(response => {
                        if(response.data && response.data.items) {
                            this.orders = response.data.items
                            this.totalRows = response.data.pagination.total;
                            NProgress.done();
                            this.isLoading = false;
                        } else {
                            this.orders = []
                            this.totalRows = ''
                            NProgress.done();
                            this.isLoading = false;
                        }
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },

            //---- Event Search
            onSearch(value) {
                this.search = value.searchTerm;
                // this.Get_Products(this.serverParams.page);
            },
            newOrder() {
                this.$router.push({path: `/app/repairs/order`})
            },
            orderDetails(props) {
                this.$router.push({path: `/app/repairs/order_details/${props.row.id}`, query: { id: props.row.id }})
            },
            getDate(item) {
                // let d = new Date(date).toLocaleString("en-US", {timeZoneName: "short"}).split(',')[0]
                let date = new Date(item).toLocaleString()
                return date
            },
            tdClassPaymentStatus(row) {
                if (row.payment_status === 'cancelled') {
                    return 'cancelled';
                } else if(row.payment_status === 'paid') {
                    return 'paid';
                } else if(row.payment_status === 'not_paid') {
                    return 'not_paid'
                }
                return 'green-class';
            },
            tdClassStatus(row) {
                if (row.status === 'waiting_for_collection') {
                    return 'waiting_collection';
                } else if(row.status === 'pending') {
                    return 'pending';
                } else if(row.status === 'done') {
                    return 'done'
                } else if(row.status === 'waiting_for_parts') {
                    return 'waiting_parts'
                }
            },
            upper(item) {
                return item.charAt(0).toUpperCase() + item.replaceAll('_', ' ').slice(1);
            },
            // printQr(props) {
            //     const printableContent =  `<img src="${props.row.qr_url}">`
            //     const printWindow = window.open('', '', 'height=900,width=900')
            //     setTimeout(() => {
            //         printWindow.document.write(printableContent)
            //         printWindow.print()
            //     }, 300)
            //
            // },

        }, //end Methods

        //-----------------------------Created function-------------------

        created() {
            this.getOrders()
        }
    }
</script>

<style scoped lang="scss">
::v-deep .vgt-table thead {
    tr th {
        background-color: #D1D5DB !important;
        font-weight: 500;
        font-size: 16px;
        line-height: 24px;
        color: #000000;
    }
}
::v-deep .vgt-table td {
    vertical-align: initial;
}
::v-deep .new_order-btn {
    border: none;
    padding: 8px 20px;
    background: #FF9900 !important;
    border-radius: 28px;
    color: #ffffff !important;
    display: flex;
    align-items: center
}
::v-deep .filter_btn {
    border: 1px solid #FF9900;
    background: #ffffff;
    padding: 8px 20px;
    border-radius: 28px;
    color: #FF9900 !important;
    display: flex;
    align-items: center
}
::v-deep .open_order-btn {
    border: none;
    padding: 8px 18px;
    background: #FF9900 !important;
    border-radius: 28px;
    color: #ffffff !important;
    line-height: 20px;
    display: flex;
    align-items: center
}
::v-deep .print_btn {
    width: 64px !important;
    height: 40px !important;
    border-radius: 6px;
    background: #F90 !important;
    border: none;
    box-shadow: 0 4px 5px 0px rgba(0, 0, 0, 0.20);
    /*display: flex;*/
    /*justify-content: center;*/
    /*align-items: center;*/
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
    ::v-deep .bar_img {
        width: 100%;
        height: 44px;
    }
    ::v-deep .vgt-table {
        & .cancelled {
            & span {
                display: none;
                width: 1px;
            }
            & div {
                margin-top: 5px;
                padding: 8px 12px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 120px;
                color: #F00;
                border-radius: 90px;
                background-color: rgba(255, 0, 0, 0.2);
            }
        }
        & .paid {
            & span {
                display: none;
                width: 1px;
            }
            & div {
                margin-top: 5px;
                padding: 8px 12px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100px;
                color: #309600;
                border-radius: 90px;
                background-color: #D6EACC;
            }
        }
        & .not_paid {
             & span {
                 display: none;
                 width: 1px;
             }
             & div {
                 margin-top: 5px;
                 padding: 8px 12px;
                 display: flex;
                 justify-content: center;
                 align-items: center;
                 width: 110px;
                 color: #FF9900;
                 border-radius: 90px;
                 background-color: rgba(255, 153, 0, 0.20);
             }
         }
        & .done {
            & span {
                display: none;
                width: 1px;
            }
            & div {
                margin-top: 5px;
                padding: 8px 12px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 80px;
                color: #309600;
                border-radius: 90px;
                background-color: #D6EACC;
            }
        }
        & .pending {
            & span {
                display: none;
                width: 1px;
            }
            & div {
                margin-top: 5px;
                padding: 8px 12px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100px;
                color: #FF9900;
                border-radius: 90px;
                background-color: rgba(255, 153, 0, 0.20);
            }
        }
        & .waiting_collection {
            & span {
                display: none;
                width: 1px;
            }
            & div {
                margin-top: 5px;
                padding: 8px 12px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 180px;
                color: #40D1FD;
                border-radius: 90px;
                background-color: rgba(207, 243, 255, 1);
            }
        }
        & .waiting_parts {
            & span {
                display: none;
                width: 1px;
            }
            & div {
                margin-top: 5px;
                padding: 8px 12px;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 160px;
                color: #A958FC;
                border-radius: 90px;
                background-color: rgba(238, 222, 254, 1);
            }
        }
    }


</style>
