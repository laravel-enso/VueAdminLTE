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
                            collapsible
                            :removable="true"
                            v-on="$listeners">


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
                            </template>t

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
            form: {
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
            };
        },

        methods: {

        },
        mounted: function () {
            this.isOpen = true; //box fix
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
