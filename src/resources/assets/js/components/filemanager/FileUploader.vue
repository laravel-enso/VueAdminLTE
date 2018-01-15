<template>

    <span>
        <span class="file-upload"
            @click="openFileBrowser">
            <slot name="upload-button">
                <i class="btn btn-xs btn-primary fa fa-upload"></i>
            </slot>
        </span>
        <form @submit.prevent>
            <input type="file"
                ref="input"
                :name="multiple ? 'files[]' : 'file'"
                :multiple="multiple"
                class="hidden"
                @change="upload">
        </form>
    </span>

</template>

<script>

    export default {
        props: {
            multiple: {
                type: Boolean,
                default: false
            },
            url: {
                type: String,
                required: true
            },
            fileSizeLimit: {
                type: Number,
                default: 8388608,
                validator(value) {
                    return value <= 8388608;
                }
            },
            params: {
                type: Object,
                default: null
            }
        },

        data() {
            return {
                formData: new FormData(),
            };
        },

        methods: {
            openFileBrowser() {
                this.$refs.input.click();
            },
            upload() {
                this.$emit('upload-start');
                this.setFormData();

                axios.post(this.url, this.formData).then(response => {
                    this.reset();
                    this.$emit('upload-successful', response.data);
                }).catch(error => {
                    this.reset();
                    this.$emit('upload-error');
                    this.reportEnsoException(error);
                });
            },
            setFormData() {
                const files = this.$refs.input.files;
                this.addFiles(files);
                this.addParams();
            },
            addFiles(files) {
                for (let i = 0; i < files.length; i++) {
                    if (this.sizeCheckPasses(files[i])) {
                        this.formData.append("file_" + i, files[i]);
                    }
                }
            },
            addParams() {
                if (this.params) {
                    for (let key in this.params) {
                        let value = typeof this.params[key] === 'object'
                            ? JSON.stringify(this.params[key])
                            : this.params[key];

                        this.formData.append(key, value);
                    }
                }
            },
            sizeCheckPasses(file) {
                if (file.size > this.fileSizeLimit) {
                    toastr.warning('File size Limit of ' + this.fileSizeLimit + ' Kb exceeded by ' + file.name);

                    return false;
                }

                return true;
            },
            reset() {
                this.formData = new FormData();
            }
        },
    };

</script>

<style>

    span.file-upload {
        background: transparent;
    }

</style>