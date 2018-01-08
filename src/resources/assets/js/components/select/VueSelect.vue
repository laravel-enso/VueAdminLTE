<template>

    <div class="vue-select">
        <multiselect :value="value"
            :internal-search="!isServerSide"
            searchable allow-empty
            :disabled="disabled"
            :multiple="multiple"
            :clear-on-select="!multiple"
            :close-on-select="!multiple"
            :select-label="labels.select"
            :deselect-label="labels.deselect"
            :selected-label="labels.selected"
            :placeholder="labels.placeholder"
            :loading="loading"
            :options-limit="100"
            :options="optionKeys"
            :custom-label="customLabel"
            @search-change="query=$event;getOptions()"
            :taggable="taggable"
            @tag="$emit('tag', $event)"
            @input="$emit('input', $event)">
            <span slot="noResult">
                {{ labels.noResult }}
            </span>
            <template slot="option" slot-scope="props">
                <span v-html="$options.filters.highlight(optionList[props.option], query)"></span>
            </template>
            <template slot="clear" slot-scope="props"
                v-if="!disabled">
                <div class="multiselect__clear"
                    v-if="hasSelection"
                    @mousedown.prevent.stop="clear()">
                </div>
            </template>
        </multiselect>
    </div>

</template>

<script>

    import Multiselect from 'vue-multiselect';

    export default {
        components: { Multiselect },

        props: {
            value: {
                default: null
            },
            source: {
                type: String,
                default: null
            },
            options: {
                type: Object,
                default() {
                    return {};
                }
            },
            taggable: {
                type: Boolean,
                default: false,
            },
            keyMap: {
                type: String,
                default: 'number'
            },
            disabled: {
                type: Boolean,
                default: false
            },
            multiple: {
                type: Boolean,
                default: false
            },
            params: {
                type: Object,
                default: null
            },
            pivotParams: {
                type: Object,
                default: null
            },
            customParams: {
                type: Object,
                default: null
            },
            placeholder: {
                type: String,
                default: null
            },
            labels: {
                type: Object,
                default() {
                    return Store ? {
                        placeholder: this.placeholder || Store.labels.selectOption,
                        selected: Store.labels.selected,
                        select: Store.labels.select,
                        deselect: Store.labels.deselect,
                        noResult: Store.labels.noResult
                    } : null;
                }
            }
        },

        computed: {
            isServerSide() {
                return this.source !== null;
            },
            hasSelection() {
                return (this.multiple && this.value.length) || (!this.multiple && this.value !== null);
            },
            optionKeys() {
                return this.keyMap === 'number'
                   ? Object.keys(this.optionList).map(Number)
                   : Object.keys(this.optionList);
            }
        },

        filters: {
            highlight(option, query) {
                if (!option) {
                    return option;
                }

                query.split(' ').filter(word => {
                    return word.length;
                }).forEach(word => {
                    option = option.replace(new RegExp('(' + word + ')', 'gi'), '<b>$1</b>')
                });

                return option;
            }
        },

        watch: {
            options: {
                handler() {
                    this.optionList = this.options;
                }
            },
            params: {
                handler() {
                    this.getOptions();
                },
                deep: true
            },
            pivotParams: {
                handler() {
                    this.getOptions();
                },
                deep: true
            },
            customParams: {
                handler() {
                    this.getOptions();
                },
                deep: true
            },
        },

        data() {
            return {
                optionList: this.options,
                loading: false,
                query: ""
            };
        },

        created() {
            this.$bus.$on('form-restored', this.update);
        },

        methods: {
            getOptions() {
                if (!this.isServerSide) {
                    return false;
                }

                this.loading = true;

                axios.get(this.source, {params: this.getParams()}).then(response => {
                    this.processOptions(response);
                    this.loading = false;
                }).catch(error => {
                    this.loading = true;
                    this.reportEnsoException(error);
                });
            },
            getParams() {
                return {
                    params: this.params,
                    pivotParams: this.pivotParams,
                    customParams: this.customParams,
                    query: this.query,
                    value: this.value
                };
            },
            processOptions(response) {
                this.optionList = response.data;
                let self = this;

                if (!this.query && !this.valueIsMatched()) {
                    this.clear();
                }
            },
            valueIsMatched() {
                let self = this;

                if (!this.multiple) {
                    return this.optionKeys.filter(option => {
                        return option === self.value;
                    }).length > 0;
                }

                return this.optionKeys.filter(option => {
                    return self.value.filter(val => {
                        return val === option;
                    }).length > 0;
                }).length > 0;
            },
            customLabel(option) {
                return this.optionList[option];
            },
            update() {
                this.$nextTick(() => {
                    this.$emit('input', this.value);
                });
            },
            clear() {
                this.$emit('input', this.multiple ? [] : null);
            },
        },

        mounted() {
            if (this.isServerSide) {
                this.getOptions();
            }
        },
    }

</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>

    div.vue-select .multiselect {
        min-height: 33px;
    }

    div.vue-select .multiselect__select {
        height: 31px;
    }

    .form-group div.vue-select .multiselect__tags {
        border: none;
        border-radius: 0;
        border-bottom: 1px solid #e8e8e8;
    }

    div.vue-select .multiselect__tags {
        min-height: 32px;
        padding: 4px 40px 0 4px;
        border-radius: 3px;
    }

    div.vue-select .multiselect__tag {
        border-radius: 3px;
        margin-bottom: 4px;
    }

    div.vue-select .multiselect__tag-icon {
        border-radius: 3px;
        line-height: 21px;
    }

    div.vue-select input[type=text].multiselect__input {
        font-size: 14px;
        box-shadow: none;
        margin-bottom: 4px;
        padding: 1px;
        border-bottom: none;
    }

    div.vue-select .multiselect__content-wrapper {
        border-bottom-left-radius: 3px;
        border-bottom-right-radius: 3px;
    }

    div.vue-select .multiselect__option,
    div.vue-select .multiselect__option:after {
        line-height: 14px;
        padding: 10px;
        min-height: 33px;

    }

    div.vue-select .multiselect__spinner {
        height: 30px
    }

    .multiselect__clear {
        position: absolute;
        top: 4px;
        right: 35px;
        height: 22px;
        width: 22px;
        display: block;
        cursor: pointer;
        z-index: 2;
    }

    .multiselect__clear:before {
        transform: rotate(45deg);
    }

    .multiselect__clear:after {
        transform: rotate(-45deg);
    }

    .multiselect__clear:after, .multiselect__clear:before {
        content: "";
        display: block;
        position: absolute;
        width: 2px;
        height: 16px;
        background: #aaa;
        top: 3px;
        right: 10px;
    }

</style>