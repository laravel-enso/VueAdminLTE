<template>

    <addresses
            @form-loaded="setCountyId"
            v-bind="$attrs"
            v-on="$listeners">

        <template slot="address-template" slot-scope="props">

        </template>

        <template slot="county_id" slot-scope="props">
            <vue-select name="county_id"
                        v-model="props.element.value"
                        @input="params.county_id=$event;props.errors.clear(props.element.column);"
                        :options="props.element.config.options">
            </vue-select>
        </template>
        <template slot="locality_id" slot-scope="props">
            <vue-select name="locality_id"
                        :params="params"
                        v-model="props.element.value"
                        @input="props.errors.clear(props.element.column);"
                        :source="props.element.config.source">
            </vue-select>
        </template>
    </addresses>

</template>
<script>

    import Addresses from './Addresses';

    export default {
        components: {Addresses},
        data() {
            return {
                params: {
                    county_id: null
                }
            };
        },
        methods: {
            getCountyId(formData) {
                let attribute = formData.attributes.find(attribute => {
                    return attribute.column === 'county_id';
                });

                return attribute.value;
            },
            setCountyId(formData) {
                this.params.county_id = this.getCountyId(formData);
            }
        }
    }

</script>