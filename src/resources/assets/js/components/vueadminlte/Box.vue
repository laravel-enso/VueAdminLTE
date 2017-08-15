<template>

    <div class="box"
        :class="boxClass">
        <div class="box-header"
            :class="headerClass">
            <i :class="icon"
                v-if="icon">
            </i>
            <h3 class="box-title"
                v-if="title">
                {{ title }}
            </h3>
            <div class="box-tools pull-right">
                <span v-if="search">
                    <i class="fa fa-search"></i>
                    <input type="text"
                        size="15"
                        class="search margin-right-xs"
                        v-model="query"
                        @input="$emit('query-update', query)">
                </span>
                <slot name="btn-box-tool"></slot>
                <span class="badge bg-orange"
                    v-if="badge !== null">
                    {{ badge }}
                </span>
                <button class="btn btn-box-tool btn-sm"
                    v-if="refresh"
                    @click="$emit('refresh')">
                    <i class="fa fa-refresh"></i>
                </button>
                <button class="btn btn-box-tool btn-sm"
                    data-widget="collapse"
                    v-if="collapsible"
                    @click="$emit('toggle-collapse')">
                    <i :class="['fa', open ? 'fa-minus' : 'fa-plus']"></i>
                </button>
                <button class="btn btn-box-tool btn-sm"
                    data-widget="remove"
                    v-if="removable"
                    @click="$emit('remove')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        <div class="box-body"
            :style="bodyStyle">
            <slot></slot>
        </div>
        <div class="box-footer"
            v-if="footer">
            <slot name="footer"></slot>
        </div>
        <overlay v-if="overlay"></overlay>
    </div>

</template>

<script>

    import Overlay from './Overlay.vue';

    export default {
        components: { Overlay },

        props: {
            theme: {
                type: String,
            },
            border: {
                type: Boolean,
                default: false
            },
            solid: {
                type: Boolean,
                default: false
            },
            open: {
                type: Boolean,
                default: false
            },
            footer: {
                type: Boolean,
                default: false
            },
            icon: {
                type: String,
                default: null
            },
            title: {
                type: String,
                default: null
            },
            search: {
                type: Boolean,
                default: false
            },
            badge: {
                type: Number,
                default: null
            },
            refresh: {
                type: Boolean,
                default: false
            },
            collapsible: {
                type: Boolean,
                default: false
            },
            removable: {
                type: Boolean,
                default: false
            },
            overlay: {
                type: Boolean,
                default: false
            },
            bodyStyle: {
                type: Object,
                default() {
                    return {}
                }
            }
        },

        computed: {
            boxClass() {
                return 'box-' + this.theme
                    + (this.solid ? ' box-solid' : '')
                    + (this.open ? '': ' collapsed-box');
            },
            headerClass() {
                return this.border ? 'with-border' : '';
            },
        },

        data() {
            return {
                query: null
            };
        }
    };

</script>

<style>

    input.search {
        color: #3c3a3a;
        vertical-align: middle;
    }

</style>