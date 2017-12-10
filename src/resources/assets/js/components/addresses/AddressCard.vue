<template>

    <small-box icon="fa fa-map"
        :theme="address.is_default ? 'bg-olive' : 'bg-gray'">
        <address class="contact-info">

            <br>
            <span v-if="address.street">Strada: {{ address.street }}</span>
            <span v-if="address.number">Numar: {{ address.number }}</span>
            <br>

            <span v-if="address.building">Bloc: {{ address.building }}</span>
            <span v-if="address.entry">Scara: {{ address.entry }}</span>
            <span v-if="address.floor">Etaj: {{ address.floor }}</span>
            <span v-if="address.apartment">Apartament: {{ address.apartment }}</span>
            <br>
            <span v-if="address.sub_administrative_area">Sector: {{ address.sub_administrative_area }}</span>
            <span v-if="address.city">Oras: {{ address.city }}</span>
            <br>
            <span v-if="address.postal_area">CP: {{ address.postal_area }}</span>
            <span v-if="address.administrative_area">Judet: {{ address.administrative_area }}</span>
            <br>
            {{ address.country_code }} <br>
            <i class="fa fa-sticky-note "></i> {{ address.obs }} <br>
        </address>
        <span slot="footer">
            <i class="fa fa-pencil-square-o pull-left margin-left-md"
                @click="handleEdit"></i>

            <i class="fa fa-anchor"
               @click="setDefault"></i>

            <i class="fa fa-trash-o pull-right margin-right-md"
                @click="showModal=true"></i>
            <div class="clearfix"></div>
        </span>

        <address-modal-form
            v-if="showForm"
            :address="address"
            :form="form"
            :type="address.addressable_type"
            :id="address.addressable_id"
            @patch="$emit('updated');showForm=false"
            @delete="$emit('deleted');showForm=false"
            @form-close="showForm=false">
        </address-modal-form>

        <modal :show="showModal"
            @cancel-action="showModal=false"
            @commit-action="destroy()">
        </modal>
    </small-box>

</template>

<script>

    import AddressModalForm from './AddressModalForm';
    export default {
        components: {AddressModalForm},
        props: {
            index: {
                type: Number,
                required: true
            },
            address: {
                type: Object,
                required: true
            },
        },

        data() {
            return {
                form: null,
                labels: Store.labels,
                showForm: false,
                showModal: false
            };
        },

        methods: {

            setDefault() {
                axios.get('/addresses/setDefault/' + this.address.id).then(response => {
                    this.$emit('default-set', response.data.message);
                }).catch((error) => {
                    this.reportEnsoException(error);
                });
            },
            handleEdit() {

                this.getForm();
            },
            getForm() {

                try {
                    axios.get('/addresses/getEditForm/' + this.address.id).then(response => {
                        this.form = response.data;
                    }).then(() => {
                        this.showForm=true;
                    });

                } catch(error) {
                    this.reportEnsoException(error);
                }
            },
            destroy() {
                this.showModal = false;

                this.$emit('delete', {index: this.index, id: this.address.id});
            }
        }
    }

</script>

<style>

    address.contact-info {
        padding-left: 5px;
        padding-top: 5px;
    }

    .small-box-footer.controls > i {
        cursor: pointer;
    }

    .modal-body {
        color: #3c3a3a !important;
    }

</style>