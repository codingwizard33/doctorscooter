<template>
    <div>
        <b-row class="align-items-center mb-2">
            <b-col class="align-items-center head_buttons">
                <button class="btn btn-outline-primary mr-5" @click="daySalesReport(1)">
                    Today
                </button>
                <button class="btn btn-outline-primary mr-5" @click="daySalesReport(7)">
                    7 days
                </button>
                <button class="btn btn-outline-primary mr-5" @click="daySalesReport(30)">
                    30 days
                </button>
            </b-col>
            <b-col>
                <b-form-group :label="$t('warehouse')">
                    <v-select
                        v-model="Filter_warehouse"
                        @input="onWarehouseChange"
                        :reduce="label => label.value"
                        :placeholder="$t('Choose_Warehouse')"
                        :options="warehouses.map(warehouse => ({label: warehouse.name, value: warehouse.id}))"
                    />
                </b-form-group>
            </b-col>
        </b-row>
        <div class="page_container">
            <div class="page_boxes">
                <div class="box_item completed">
                    <div class="box_item-icon">
                        <div class="icon"></div>
                    </div>
                    <div v-if="allData" class="point">{{allData.done || 0}}</div>
                    <div class="box_item-title">Complete Repairs</div>
                </div>
                <div class="box_item pending">
                    <div class="box_item-icon">
                        <div class="icon"></div>
                    </div>
                    <div v-if="allData" class="point">{{allData.pending || 0}}</div>
                    <div class="box_item-title">Pending Repairs</div>
                </div>
                <div class="box_item waiting">
                    <div class="box_item-icon">
                        <div class="icon"></div>
                    </div>
                    <div v-if="allData" class="point">{{allData.waiting_for_parts || 0}}</div>
                    <div class="box_item-title">Waiting For Parts</div>
                </div>
                <div class="box_item collection">
                    <div class="box_item-icon">
                        <div class="icon"></div>
                    </div>
                    <div v-if="allData" class="point">{{allData.waiting_for_collection || 0}}</div>
                    <div class="box_item-title">Waiting For Collection</div>
                </div>
            </div>

            <div class="working_on-container">
                <div class="working_on-title">Working On</div>
                <div class="working_on-content">
                    <div v-for="item of workings" class="working_on-item">
                        <div class="user_data">
                            <div class="user_data-avatar">
                                <img :src="item.avatar == 'no_avatar.png' ? NoAvatar: item.avatar" alt="">
                            </div>
                            <div class="user_data-name">
                                <div class="name">{{item.name}}</div>
                                <div class="spec">Technical</div>
                            </div>
                        </div>

                        <div class="user_data-item completed" :class="{'pointer':item.done != 0 }" @click="getTechnicData(item, 'done')">
                            <div class="user_data-item_avatar">
                                <div class="small_avatar"></div>
                            </div>
                            <div class="user_data-item_name">
                                <div class="item_name">Complete Repairs</div>
                                <div class="item_point">{{item.done}}</div>
                            </div>
                        </div>
                        <div class="user_data-item pending" :class="{'pointer':item.pending != 0 }" @click="getTechnicData(item, 'pending')">
                            <div class="user_data-item_avatar">
                                <div class="small_avatar"></div>
                            </div>
                            <div class="user_data-item_name">
                                <div class="item_name">Pending Repairs</div>
                                <div class="item_point">{{item.pending}}</div>
                            </div>
                        </div>
                        <div class="user_data-item waiting" :class="{'pointer':item.waiting_for_parts != 0 }" @click="getTechnicData(item, 'waiting_for_parts')">
                            <div class="user_data-item_avatar">
                                <div class="small_avatar"></div>
                            </div>
                            <div class="user_data-item_name">
                                <div class="item_name">Waiting for Parts</div>
                                <div class="item_point">{{item.waiting_for_parts}}</div>
                            </div>
                        </div>
                        <div class="user_data-item collection" :class="{'pointer':item.waiting_for_collection != 0 }" @click="getTechnicData(item, 'waiting_for_collection')">
                            <div class="user_data-item_avatar">
                                <div class="small_avatar"></div>
                            </div>
                            <div class="user_data-item_name">
                                <div class="item_name">Waiting for Colloection</div>
                                <div class="item_point">{{item.waiting_for_collection}}</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NoAvatar from '/images/avatar.png'
import {mapGetters} from "vuex";

export default {
    name: "RepairSystem",
    data() {
        return {
            allData: null,
            NoAvatar,
            workings: [],
            Filter_warehouse: null,
            warehouses: [],
        }
    },
    created() {

    },
    computed: {
        ...mapGetters(["currentUser"]),
    },
    mounted() {
        if (this.currentUser.warehouse) {
            this.warehouses.push(this.currentUser.warehouse)
        } else {
            this.getWarehouses()
        }
        this.getSystemData()
    },
    methods: {
        getWarehouses() {
            axios
                .get(`/get-warehouses`)
                .then(response => {
                    this.warehouses = response.data;
                })
                .catch(error => {
                    console.log(error)
                })

        },
        getSystemData() {
            axios
                .get(`/reaper/order/repair-system`)
                .then(response => {
                    this.workings = response.data.techniciansData
                    this.allData = response.data.allData
                })
                .catch(error => {
                    console.log(error)
                })
        },
        daySalesReport(day) {
            let warehouse_id = this.Filter_warehouse
            axios
                .get(`/reaper/order/repair-system-filter/${day}/${warehouse_id}`)
                .then(response => {
                    this.workings = response.data.techniciansData
                    this.allData = response.data.allData
                    console.log('repair-system-filter ', response.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        onWarehouseChange(ev) {
            axios
                .get(`/reaper/order/repair-system-filter-warehouse/${ev}`)
                .then(response => {
                    this.workings = response.data.techniciansData
                    this.allData = response.data.allData
                    console.log(response.data, 'repair-system-filter-warehouse')
                })
                .catch(error => {
                    console.log(error)
                })
        },
        getTechnicData(item, status) {
            if (item[status] != 0) {
                console.log(item)
                console.log(status)
                this.$router.push({path: `/app/repairs/repair_orders`, query: { id: item.id, status: status }})

            } else {

            }


        }

    }

}
</script>

<style scoped lang="scss">
::v-deep .head_buttons {
    & .btn {
        &:focus {
            background: #FF9800;
            box-shadow: 0 8px 25px -8px #FF9800;
            border-color: #FF9800;
            color: #111827;
        }
    }
}

.page {
    &_container {
        display: flex;
        width: 100%;
        flex-direction: column;

        & .working_on {
            &-container {
                display: flex;
                flex-direction: column;
                background: #FFFFFF;
                border: 1.55215px solid #EAEAEA;
                box-shadow: 0 6.2086px 15.5215px rgba(0, 0, 0, 0.04);
                border-radius: 23.2823px;
                padding: 12px 40px;
            }

            &-title {
                font-weight: 500;
                font-size: 32px;
                line-height: 44px;
                color: #263238;
                margin-bottom: 17px;
            }

            &-item {
                background: #FFFFFF;
                border: 0.886944px solid #EAEAEA;
                box-shadow: 0 7.09555px 17.7389px rgba(0, 0, 0, 0.04);
                border-radius: 8.86944px;
                padding: 17px 18px;
                margin: 10px 0;
                display: flex;
                align-items: center;
                justify-content: space-between;

                & .user_data {
                    display: flex;
                    width: 18%;

                    &-avatar {
                        width: 71px;
                        height: 76px;

                        & img {
                            border-radius: 12px;
                        }

                        /*background: url("/images/avatar.png");*/
                    }

                    &-name {
                        padding: 1px 14px;
                        display: flex;
                        flex-direction: column;
                        justify-content: space-between;
                        max-width: 215px;
                        width: 100%;

                        & .name {
                            font-weight: 500;
                            font-size: 23.0605px;
                            line-height: 35px;
                            color: #263238;
                        }

                        & .spec {
                            font-weight: 400;
                            font-size: 20px;
                            line-height: 30px;
                            color: #C0C0C0;
                        }
                    }

                    &-item {
                        border-left: 2px solid #E8E8E8;
                        display: flex;
                        align-items: center;
                        padding-left: 32px;
                        &.pointer {
                        cursor: pointer;
                            &:hover {
                                border-left: 2px solid #808080;
                            }
                    }

                        &_name {
                            display: flex;
                            flex-direction: column;
                            justify-content: space-between;
                            padding-left: 14px;

                            & .item_name {
                                font-weight: 600;
                                font-size: 17px;
                                line-height: 20px;
                                color: #717171;
                                margin-bottom: 10px;
                            }
                        }

                        &.completed {
                            & .user_data-item_avatar {
                                width: 63px;
                                height: 66px;
                                border-radius: 16px;
                                background: #DAF7EB;
                                display: flex;
                                align-items: center;
                                justify-content: center;

                                & .small_avatar {
                                    width: 30px;
                                    height: 30px;
                                    background: url("/images/completed_small.svg");
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    background-size: contain;
                                }

                            }

                            & .item_point {
                                font-weight: 700;
                                font-size: 28px;
                                line-height: 32px;
                                color: #42B844;
                            }

                        }

                        &.pending {
                            & .user_data-item_avatar {
                                width: 63px;
                                height: 66px;
                                border-radius: 16px;
                                background: #FFE5BF;
                                display: flex;
                                align-items: center;
                                justify-content: center;

                                & .small_avatar {
                                    width: 30px;
                                    height: 30px;
                                    background: url("/images/pending_small.svg");
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    background-size: contain;
                                }
                            }

                            & .item_point {
                                font-weight: 700;
                                font-size: 28px;
                                line-height: 32px;
                                color: #FF9900;
                            }
                        }

                        &.waiting {
                            & .user_data-item_avatar {
                                width: 63px;
                                height: 66px;
                                border-radius: 16px;
                                background: #EEDEFE;
                                display: flex;
                                align-items: center;
                                justify-content: center;

                                & .small_avatar {
                                    width: 30px;
                                    height: 30px;
                                    background: url("/images/waiting_small.svg");
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    background-size: contain;
                                }
                            }

                            & .item_point {
                                font-weight: 700;
                                font-size: 28px;
                                line-height: 32px;
                                color: #A958FC;
                            }
                        }

                        &.collection {
                            & .user_data-item_avatar {
                                width: 63px;
                                height: 66px;
                                border-radius: 16px;
                                background: #CFF3FF;
                                display: flex;
                                align-items: center;
                                justify-content: center;

                                & .small_avatar {
                                    width: 30px;
                                    height: 30px;
                                    background: url("/images/collection_small.svg");
                                    background-position: center;
                                    background-repeat: no-repeat;
                                    background-size: contain;
                                }
                            }

                            & .item_point {
                                font-weight: 700;
                                font-size: 28px;
                                line-height: 32px;
                                color: #40D1FD;
                            }

                        }

                    }
                }
            }
        }
    }

    &_boxes {
        display: flex;
        justify-content: space-between;
        margin-bottom: 39px;

        & .box_item {
            width: 395px;
            height: 380px;
            background: #FFFFFF;
            border: 1.55215px solid #EAEAEA;
            box-shadow: 0px 6.2086px 15.5215px rgba(0, 0, 0, 0.04);
            border-radius: 23.2823px;
            padding: 36px;
            display: flex;
            flex-direction: column;

            &-title {
                font-weight: 500;
                font-size: 34px;
                line-height: 44px;
                color: #4F5D64;
                letter-spacing: -1px;
            }

            &-icon {
                width: 89px;
                height: 94px;
                border-radius: 26px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            &.completed {
                & .box_item-icon {
                    background: #DAF7EB;
                }

                & .icon {
                    width: 42px;
                    height: 42px;
                    background: url("/images/completed_small.svg");
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: contain;
                }

                & .point {
                    padding: 53px 0 20px;
                    font-family: 'Helvetica', sans-serif;
                    font-weight: 400;
                    font-size: 65px;
                    line-height: 75px;
                    color: #42B844;
                }
            }

            &.pending {
                & .box_item-icon {
                    background: #FFE5BF;
                }

                & .icon {
                    width: 42px;
                    height: 42px;
                    background: url("/images/pending_small.svg");
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: contain;
                }

                & .point {
                    padding: 53px 0 20px;
                    font-family: 'Helvetica';
                    font-weight: 400;
                    font-size: 65px;
                    line-height: 75px;
                    color: #FF9900;
                }
            }

            &.waiting {
                & .box_item-icon {
                    background: #EEDEFE;
                }

                & .icon {
                    width: 42px;
                    height: 42px;
                    background: url("/images/waiting_small.svg");
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: contain;
                }

                & .point {
                    padding: 53px 0 20px;
                    font-family: 'Helvetica';
                    font-weight: 400;
                    font-size: 65px;
                    line-height: 75px;
                    color: #A958FC;
                }
            }

            &.collection {
                & .box_item-icon {
                    background: #CFF3FF;
                }

                & .icon {
                    width: 42px;
                    height: 42px;
                    background: url("/images/collection_small.svg");
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: contain;
                }

                & .point {
                    padding: 53px 0 20px;
                    font-family: 'Helvetica', sans-serif;
                    font-weight: 400;
                    font-size: 65px;
                    line-height: 75px;
                    color: #40D1FD;
                }
            }
        }
    }
}
</style>
