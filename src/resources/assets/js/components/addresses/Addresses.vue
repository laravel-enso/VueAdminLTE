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
                        @set-default="setDefault(address)"
                        @edit="edit(address)"
                        @delete="destroy(address, index)"
                        :index="index">

                            <template slot="address-card-template" :address="address">
                                <slot name="address-template" :address="address">
                                </slot>
                            </template>

                    </address-card>
                </div>
            </div>
        </div>
        <address-form
            v-if="form"
            :form="form"
            :type="type"
            :id="id"
            ref="modal"
            @patch="get();form=null"
            @form-close="form=null"
            @post="get();form=null"
            @delete="get();form=null"
            @store="get();form=null">

            <template
                v-for="element in form.attributes"
                v-if="element.config.custom"
                :slot="element.column"
                slot-scope="props">
                    <slot
                        :name="props.element.column"
                        :element="props.element"
                        :errors="props.errors">
                    </slot>
            </template>

        </address-form>
    </box>

</template>

<script>

    import AddressCard from './AddressCard';
    import AddressForm from './AddressForm';
    export default {
        components: { AddressCard, AddressForm },
        props: {
            id: {
                type: Number,
                required: true,
            },
            type: {
                type: String,
                required: true,
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
                default: false,
            },
            title: {
                type: String,
                default: null,
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
                bodyStyle: {'max-height': '415px', 'overflow-y': 'auto'},
                form: null,
            };
        },

        created() {
            this.get();
        },

        methods: {

            edit(address) {
                this.loading = true;

                axios.get('/addresses/' + address.id + '/edit').then(response => {
                    this.loading = false;
                    this.$emit('form-loaded', response.data);
                    this.form = response.data;
                }).catch( error => {
                    this.loading = false;
                    this.reportEnsoException(error);
                });
            },
            create() {
                if (this.$refs.box.collapsed) {
                    this.$refs.box.toggle();
                }

                const params = {addressable_id: this.id, addressable_type: this.type};
                this.loading = true;

                axios.get('/addresses/create', {params: params}).then(response => {
                    this.loading = false;
                    this.form = response.data;
                }).catch( error => {
                    this.loading = false;
                    this.reportEnsoException(error);
                });
            },
            setDefault(address) {
                this.loading = true;

                axios.get('/addresses/setDefault/' + address.id).then(() => {
                    this.loading = false;
                    this.get();
                }).catch((error) => {
                    this.loading = false;
                    this.reportEnsoException(error);
                });
            },
            get() {
                this.loading = true;

                axios.get('/addresses', { params: { id: this.id, type: this.type } }).then(response => {
                    this.addresses = response.data;
                    this.loading = false;
                }).catch( error  => {
                    this.loading = false;
                    this.reportEnsoException(error);
                });
            },

            destroy(address, index) {

                axios.delete('/addresses/' + address.id).then(response => {
                    this.$parent.loading = false;
                    this.addresses.splice(index, 1);
                }).catch(error => {
                    this.$parent.loading = false;
                    this.reportEnsoException(error);
                });
            }
        },
    }

</script>

<style scoped>

    .box-body > div.contacts {
        overflow-y: auto;
        max-height: 358px;
    }

</style>