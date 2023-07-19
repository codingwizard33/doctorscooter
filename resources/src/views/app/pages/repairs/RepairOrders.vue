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
                @on-search="onSearch"
                styleClass="tableOne vgt-table"
            >
                <div slot="table-actions" class="mb-1 d-flex">
                    <b-button class="new_order-btn mx-3" @click="newOrder()">
                        <span class="d-flex"><i class="i-Add"></i></span>
                        <span class="ul-btn__text ml-1">{{$t('New')}}</span>
                    </b-button>
                    <b-button class="filter_btn" size="sm">
                        <span class="d-flex"><i class="i-Filter-2"></i></span>
                        <span class="ul-btn__text ml-1">{{ $t("Filter") }}</span>
                    </b-button>

                </div>
                <template slot="table-row" slot-scope="props">
                    <b-button v-if="props.column.field == 'action'" class="open_order-btn" @click="orderDetails(props)">
                        Open Order <span class="ml-2 d-flex"><i class="i-Arrow-Right"></i></span>
                    </b-button>
                </template>

            </vue-good-table>
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
                orders: {}
            }
        },
        computed: {
            columns() {
                return [
                    {
                        label: this.$t("Reference"),
                        field: "bar_code",
                        html: true,
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
                        tdClass: "text-left",
                        thClass: "text-left"
                    },
                    {
                        label: this.$t("Status"),
                        field: "status",
                        tdClass: "text-left",
                        thClass: "text-left"
                    },
                    {
                        label: this.$t("UpdatedAt"),
                        field: "updated_at",
                        tdClass: "text-left",
                        thClass: "text-left"
                    },
                    {
                        label: '',
                        field: "action",
                        tdClass: "text-left",
                        thClass: "text-left"
                    },

                ];
            }
        },
        methods: {
            getOrders() {
                NProgress.start();
                NProgress.set(0.1);
                axios.get('/reaper/order')
                    .then(response => {
                        this.orders = response.data.items
                        this.totalRows = response.data.pagination.total;
                        NProgress.done();
                        this.isLoading = false;
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
            }
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
</style>
