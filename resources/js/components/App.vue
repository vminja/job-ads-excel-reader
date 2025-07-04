<template>
    <div>
        <div class="d-flex justify-content-center align-items-center my-5">
            <div class="card p-4 shadow" style="min-width: 350px; width: 400px;">
                <form>
                    <label for="fileInput" id="fileInput" class="form-label text-center w-100">Izaberite fajl</label>
                    <input @change="onFileChange" class="form-control" type="file" id="customFile">
                    <label class="fw-bold mt-2 text-danger">{{ fileMessage }}</label>

                    <div class="d-grid gap-2">
                        <button type="button" class="mt-1 btn btn-light" data-bs-toggle="collapse" data-bs-target="#filteri_accordion">Filteri</button>
                    </div>

                    <div class="accordion-item mt-1">
                        <div id="filteri_accordion" class="accordion-collapse collapse">
                            <div class="accordion-body border p-2 rounded">
                                <div class="mb-2">
                                    <label class="form-label">Tehnologije</label>
                                    <div class="row">
                                        <div class="col-6" v-for="(tehnologija, index) in tehnologije" :key="index">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" :id="'tehnologija_' + index" v-model="tehnologija.active">
                                                <label class="form-check-label" :for="'tehnologija_' + index">{{ tehnologija.name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button @click="searchResults" type="button" class="btn btn-warning mt-3">Pretraži <i class="bi bi-search"></i></button>
                    </div>
                </form>
            </div>
        </div>

        
        
        <div class="d-flex row mx-1 justify-content-center align-items-center">
            <div class="col-4 my-2" v-for="oglas in oglasi">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{oglas[0]}}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">{{oglas[1]}} - {{oglas[2]}}</h6>
                        <p class="card-text">Tehnologije: {{oglas[4]}}</p>
                        <a :href="oglas[3]" target="_blank" class="card-link">Link ka oglasu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {

    },
    data() {
        return {
            selectedFile: null,
            fileMessage: "",
            oglasi: null,

            tehnologije: [
                { name: "JavaScript", active: false },
                { name: "Python", active: false },
                { name: "Java", active: false },
                { name: "C#", active: false },
                { name: "PHP", active: false },
                { name: "Laravel", active: false },
                { name: "Vue.js", active: false },
                { name: "WordPress", active: false }
            ]

        };
    },
    mounted() {
        
    },
    methods: {
        onFileChange(event) {
            let file = event.target.files[0];
            const allowedExtensions = ["xls", "xlsx", "csv"];

            if (file && allowedExtensions.some((ext) => file.name.endsWith("." + ext)) && file.size != 0) {
                this.fileMessage = "";
                this.selectedFile = file;
            } else {
                this.selectedFile = "";
                this.fileMessage = "Molimo Vas da unesete odgovarajući fajl.";
            }
        },
        searchResults(){
            let th = this;
            const formData = new FormData();
            formData.append('file', th.selectedFile);
            formData.append('tehnologije', JSON.stringify(th.tehnologije.filter(t => t.active).map(t => t.name)));

            axios.post("/updateFile", formData, {

            }).then( response => {
                // console.log("Response ", response.data);
                th.oglasi = response.data;

            }).catch( error => {
                console.error("Greska ", error.response.error)
            })
        }
      
    }
};
</script>