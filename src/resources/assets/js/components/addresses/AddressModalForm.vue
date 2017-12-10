<template>
    <transition name="modal" >
        <div class="address-modal-mask flex-center-xy">
            <div class="address-modal-container">
                <div class="col-md-12">
                    <div class="row">
                        <vue-form
                            v-if="form"
                            :data="form"
                            :open="isOpen"
                            :removable="true"
                            ref="addressForm"
                            v-on="$listeners">
                        </vue-form>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>

    export default {
        props: {
            id: {
                default: null
            },
            type: {
                type: String,
                default: ""
            },
            address: {
                type: Object,
                default: null
            },
        },

        computed: {

        },

        data() {
            return {
                errors: {},
                labels: Store.labels,
                isOpen: false,
                form: null
            };
        },

        methods: {
            getEditForm() {
                axios.get('/addresses/getEditForm/' + this.address.id).then(response => {
                    this.form = response.data;
                }).then(()=> {
                    this.isOpen = true; //box fix
                }).catch( error => {
                    this.reportEnsoException(error);
                });
            },
            getCreateForm() {
                const params = {addressable_id: this.id, addressable_type: this.type};
                axios.get('/addresses/getCreateForm', {params: params}).then(response => {
                    this.form = response.data;
                }).then(()=> {
                    this.isOpen = true; //box fix
                }).catch( error => {
                    this.reportEnsoException(error);
                });

            },
        },
        mounted: function () {
            this.$nextTick(()=>{
                this.address ? this.getEditForm() : this.getCreateForm();
            });
        }
    }

</script>

<style>
    .address-modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        transition: opacity .3s ease;
    }

    .address-modal-container {
        min-width: 250px;
        min-height: 415px;
        width:80%;
        max-height: 90%;
        overflow-y: auto;
        margin: 0 auto;
        padding: 0;
        color: #3c3a3a;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
    }

    .address-modal-container .box {
        margin-bottom: 0;
        padding-left: 5px;
        padding-right: 5px;
    }
</style>
