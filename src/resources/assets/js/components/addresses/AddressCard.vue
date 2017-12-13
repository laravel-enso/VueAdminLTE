<template>

    <small-box icon="fa fa-map"
        :theme="address.is_default ? 'bg-olive' : 'bg-gray'">
        <address class="contact-info">

            <!--default slot content will be overwritten if anything is provided-->
            <slot name="address-card-template" :address="address">
                <br>
                <span v-if="address.street">{{labels.street}}: {{ address.street }}</span>
                <span v-if="address.number">{{labels.number}}: {{ address.number }}</span>
                <br>

                <span v-if="address.building">{{labels.building}}: {{ address.building }}</span>
                <span v-if="address.entry">{{labels.entry}}: {{ address.entry }}</span>
                <span v-if="address.floor">{{labels.floor}}: {{ address.floor }}</span>
                <span v-if="address.apartment">{{labels.apartment}}: {{ address.apartment }}</span>
                <br>
                <span v-if="address.sub_administrative_area">{{labels.subAdministrativeArea}}: {{ address.sub_administrative_area }}</span>
                <span v-if="address.city">{{labels.city}}: {{ address.city }}</span>
                <br>
                <span v-if="address.postal_area">{{labels.postalArea}}: {{ address.postal_area }}</span>
                <span v-if="address.administrative_area">{{labels.administrativeArea}}: {{ address.administrative_area }}</span>
                <br>
                {{ address.country_name }} <br>
                <i class="fa fa-sticky-note "></i> {{ address.obs }} <br>
            </slot>

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
                this.$emit('do-edit');
            },
            destroy() {
                this.showModal = false;
                this.$emit('do-delete', {index: this.index, id: this.address.id});
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