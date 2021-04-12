<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 my-4">
                <h1>Animal Translator v0.0.1</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="btn-group" role="group">
                            <template v-if="inputText.length > 0">
                                <input type="radio" class="btn-check" @change="selectSourceLanguage" value="autodetect" v-model="sourceLanguageSelected" name="sourceLanguageSelected" id="btnradio1" autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnradio1">Taal herkennen</label>
                            </template>

                            <template v-for="(label, language) in sourceLanguages">
                                <input type="radio" @change="selectSourceLanguage" :value="language"  v-model="sourceLanguageSelected"  class="btn-check" name="sourceLanguageSelected" :id="'btnSourceFor' + language" autocomplete="off">
                                <label class="btn btn-outline-primary" :for="'btnSourceFor' + language">{{ label }}</label>
                            </template>
                        </div>
                        <div class="spacer" v-if="sourceLanguageSelected !== null"></div>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" v-model="inputText" rows="5"></textarea>
                        <div class="alert alert-info mt-4" v-if="sourceLanguageDetected">
                            Gedetecteerde taal is "{{ sourceLanguages[sourceLanguageDetected] }}"
                        </div>
                        <div class="alert alert-danger mt-4" v-for="messages in errors">
                            <div v-for="message in messages">
                                {{ message }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 d-flex justify-content-center align-items-center">
                <button type="button" class="btn btn-primary" :disabled="buttonDisabled" @click="translate">
                    Vertaal
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </button>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <div class="btn-group" role="group">
                            <template v-for="(label, language) in targetLanguages">
                                <input type="radio" :value="language"  v-model="targetLanguageSelected"  class="btn-check" name="targetLanguageSelected" :id="'btnTargetFor' + language" autocomplete="off">
                                <label class="btn btn-outline-primary" :for="'btnTargetFor' + language">{{ label }}</label>
                            </template>
                            <template v-if="sourceLanguageSelected === null">
                                <input type="radio" class="btn-check" id="btnDisabled" disabled autocomplete="off">
                                <label class="btn btn-outline-primary" for="btnDisabled">Selecteer eerst een brontaal...</label>
                            </template>
                        </div>
                        <div class="form-check mt-2 ps-0" v-if="sourceLanguageSelected !== null">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" v-model="drunk" id="drunkCheck">
                                <label class="form-check-label" for="drunkCheck">Ik ben zo dronken!!!</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" v-model="outputText" rows="5"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                drunk:                  false,
                errors:                 null,
                inputText:              '',
                outputText:             '',
                buttonDisabled:         true,
                sourceLanguages:        null,
                targetLanguages:        null,
                sourceLanguageSelected: null,
                targetLanguageSelected: null,
                sourceLanguageDetected: null,
            }
        },
        watch: {
            drunk() {
                this.enableTranslationButton();
            },
            inputText() {
                this.enableTranslationButton();
                this.enableAutodetect();
            },
            targetLanguageSelected() {
                this.enableTranslationButton();
            },
        },
        methods: {
            /**
             * Autodetect language while typing, debounced.
             */
            enableAutodetect: _.debounce(function (e) {
                this.autodetectLanguage();
            }, 500),

            /**
             * Set source language, or try autodetect.
             * Can't be run through watch, because it mustn't be triggered when set by autodetect
             */
            selectSourceLanguage() {
                if(this.sourceLanguageSelected !== 'autodetect') {
                    this.sourceLanguageDetected = null;
                    this.getTargetLanguages(this.sourceLanguageSelected);
                } else {
                    this.autodetectLanguage();
                }
            },

            /**
             * When inputText has a minimum length of 2 chars, enable translation button.
             * Don't enable button if no target language was selected
             */
            enableTranslationButton() {
                if(this.inputText.length > 0 && this.targetLanguageSelected !== null) {
                    this.buttonDisabled = false;
                } else {
                    this.buttonDisabled = true;
                }
            },

            /**
             * Get all available source languages
             */
            getSourceLanguages() {
                this.errors         = null;

                axios
                  .get('/api/available-languages')
                  .then(response => (this.sourceLanguages = response.data))
                  .catch(error => (this.errors = error.response.data.errors));
            },

            /**
             * Get all available target languages, based on selected source.
             * Deselect selected target language, in case it's no longer available with new source
             */
            getTargetLanguages(source) {
                this.targetLanguages        = null;
                this.targetLanguageSelected = null;
                this.errors                 = null;

                axios
                    .get('/api/available-languages/' + source)
                    .then((response) => {
                        this.targetLanguages        = response.data;
                        this.targetLanguageSelected = Object.keys(response.data)[0]
                    })
                    .catch(error => (this.errors = error.response.data.errors));
            },

            /**
             * Autodetect language based on inputText, then set available target languages
             */
            autodetectLanguage() {
                if(this.inputText.length > 0) {
                    this.errors         = null;

                    axios
                        .post('/api/autodetect-language', {inputText: this.inputText})
                        .then((response) => {
                            this.sourceLanguageDetected = response.data.detected_language;

                            if(this.sourceLanguageDetected !== this.sourceLanguageSelected) {
                                this.targetLanguages        = response.data.languages;
                                this.sourceLanguageSelected = response.data.detected_language;
                                this.targetLanguageSelected = Object.keys(this.targetLanguages)[0]
                            }
                        })
                        .catch(error => (this.errors = error.response.data.errors));
                }
            },
            translate() {
                this.buttonDisabled = true;
                this.errors         = null;

                axios
                    .post('/api/translate', {
                        sourceLanguage: this.sourceLanguageSelected,
                        targetLanguage: this.targetLanguageSelected,
                        inputText:      this.inputText,
                        drunk:          this.drunk,
                    })
                    .then((response) => {
                        this.outputText = response.data;
                    })
                    .catch(error => (this.errors = error.response.data.errors));
            }
        },
        mounted() {
            this.getSourceLanguages();
        }
    }
</script>
<style lang="scss">
    .spacer {
        height: 2.125rem;
    }
</style>
