<template>

    <box :theme="theme"
        collapsible refresh search removable
        :border="!solid"
        :solid="solid"
        :body-style="bodyStyle"
        :open="open"
        @refresh="get()"
        icon="fa fa-map-signs"
        :title="title || labels.addresses"
        :overlay="loading"
        ref="box"
        @query-update="query = $event"
        :badge="addresses.length">
        <span slot="btn-box-tool">
            <button class="btn btn-box-tool btn-sm fa fa-plus-square"
                @click="create()">
            </button>
        </span>
        <div class="contacts">
            <div v-for="(address, index) in filteredAddresses">
                <div class="col-sm-6 col-lg-4">
                    <address-card :address="address"
                        @updated="get"
                        @edit="get"
                        @default-set="handleDefaultSet"
                        @deleted="get"
                        @delete="destroy"
                        :index="index">
                    </address-card>
                </div>
            </div>
        </div>
        <address-modal-form
            v-if="showForm"
            :type="type"
            :id="id"
            @form-close="showForm=false"
            @post="get();showForm=false"
            @delete="get();showForm=false"
            @store="get();showForm=false">
        </address-modal-form>
    </box>

</template>

<script>

    import AddressCard from './AddressCard';
    import AddressModalForm from './AddressModalForm';
    export default {
        components: {AddressCard, AddressModalForm},
        props: {
            id: {
                type: Number,
                required: true
            },
            type: {
                type: String,
                required: true
            },
            theme: {
                type: String,
                default: 'primary'
            },
            solid: {
                type: Boolean,
                default: false,
            },
            open: {
                type: Boolean,
                default: false
            },
            title: {
                type: String,
                default: null
            }
        },

        computed: {
            filteredAddresses() {
                return this.query
                    ? this.addresses.filter(address => {
                        return address.city.toLowerCase().indexOf(this.query.toLowerCase()) > -1
                            || address.street.toLowerCase().indexOf(this.query.toLowerCase()) > -1
                            || address.number.toLowerCase().indexOf(this.query.toLowerCase()) > -1;
                    })
                    : this.addresses;
            },
        },

        data() {
            return {
                labels: Store.labels,
                loading: false,
                query: '',
                addresses: [],
                showForm: false,
                bodyStyle: {'max-height': '415px', 'overflow-y': 'auto'}
            };
        },

        methods: {

            handleDefaultSet($event) {
                this.get();
                toastr.success($event);
            },
            get() {
                this.loading = true;

                axios.get('/addresses/list', { params: { id: this.id, type: this.type } }).then(response => {
                    this.addresses = response.data;
                    this.loading = false;
                }).catch(error => {
                    this.loading = false;
                    this.reportEnsoException(error);
                });
            },
            create() {
                if (this.$refs.box.collapsed) {
                    this.$refs.box.toggle();
                }

                this.showForm=true;
            },
            destroy(payload) {

                axios.delete('/addresses/' + payload.id).then(response => {
                    this.$parent.loading = false;
                    this.addresses.splice(payload.index,1);
                }).catch(error => {
                    this.$parent.loading = false;
                    this.reportEnsoException(error);
                });
            }
        },

        mounted() {
            this.get();
        }
    }

</script>

<style>

    .box-body > div.contacts {
        overflow-y: auto;
        max-height: 358px;
    }

</style>