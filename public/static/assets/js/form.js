class SurveyDraft {

    // FORMU BAŞLAT
    async startForm(form_id) {
        // JSON verisini al ve işle
        const facilitiesJSON = $("#facilities").val();
        const facilities = JSON.parse(facilitiesJSON);

        // Tesisleri seçeneklere dönüştür
        const options = {};
        facilities.forEach(element => {
            options[element.id] = element.title;
        });

        // İlk SweetAlert: Tesis seçimini yap
        const facilityResult = await swal.fire({
            title: 'Hangi Tesis Bakıma Alınıyor?',
            input: 'select',
            inputOptions: options,
            inputAttributes: {
                className: 'form-control'
            },
            showCloseButton: true,
        });

        if (facilityResult.value) {
            const tesis_id = facilityResult.value;

            // İkinci SweetAlert: Tesis durumu seçimi
            const statusResult = await swal.fire({
                title: "Tesisin Durumu Nedir?",
                showConfirmButton: true,
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: '<i class="fas fa-power-off"></i> Kapalı',
                confirmButtonText: '<i class="fas fa-power-off"></i> Açık',
                confirmButtonColor: "green",
                cancelButtonColor: "red",
                focusConfirm: false,
            });

            const tesis_durum = statusResult.value ? 1 : 0;

            // Formu başlat
            const data = await this.saveForm(form_id, tesis_id, tesis_durum);
            const question = await this.questionFire(form_id, 1, data.draft, data.key);
        }
    }

    // FORM BİLGİSİNİ KAYDET
    async saveForm(form_id, tesis_id, tesis_durum) {
        try {
           const response = await axios.post('/form/save/anket', {
                form: form_id,
                tesis: tesis_id,
                tesis_durum: tesis_durum
            });

            return response.data;
            
        } catch (error) {
            console.error("Hata:", error);
        }
    }

    // SORU GÖNDER
    async questionFire(formId, questionNumber, draft, key) {
        try {
            // Soru verilerini almak için istek at
            const response = await axios.post('/get-questions', {
                formid: formId,
                soru: questionNumber
            });

            if (response.data.soru) {
                const soruData = response.data.soru;
                var confirmed = 0;
                let requiredConfirm = '';
                let nextButton = '<button type="button" class="btn btn-primary" id="nextButton">İleri</button>';

                if (soruData.confirmation) {
                    confirmed = 1;
                    // Admin verilerini almak için istek at
                    const adminsResponse = await axios.post('/get-admins');
                    const admins = adminsResponse.data;

                    // Admin seçeneklerini oluştur
                    let adminOptions = '<option value="0">Yönetici Seç...</option>';
                    admins.forEach(admin => {
                        adminOptions += `<option value="${admin.id}">${admin.name}</option>`;
                    });

                    requiredConfirm = `<div class="alert alert-warning row" role="alert">
                                        <span class="col-6">Bu soru yönetici doğrulaması gerektiriyor:</span>
                                        <input type="hidden" id="selectAdminSoru" value="${soruData.id}">
                                        <select class="form-control col-6" id="selectAdmin" onchange="Draft.adminSelect()">${adminOptions}</select>
                                    </div>`;

                    nextButton = '<button type="button" class="btn btn-primary" id="nextButton" disabled>Next</button>';
                }

                // Modal içeriği oluştur
                const modalContent = `<div class="modal fade" id="QuestionModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="QuestionModal"># ${soruData.align} - ${soruData.title}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <span style="font-weight:bold; font-size:1.3rem">${soruData.question}</span>
                                                    <hr>
                                                    <div class="form-check mb-4">
                                                        <input class="problemExists" type="radio" name="answers" id="problemExists" value="0">
                                                        <label for="problemExists">Sorun Var</label>
                                                    </div>
                                                    <div class="form-check mb-4">
                                                        <input type="radio" name="answers" id="problemNotExists" value="1" checked>
                                                        <label for="problemNotExists">Sorun Yok</label>
                                                    </div>
                                                    ${requiredConfirm}
                                                    <input type="hidden" id="code">
                                                </div>
                                                <div class="modal-footer d-flex justify-content-between">
                                                    <input type="text" class="form-control col-4 note" placeholder="Notlar" id="notes">
                                                    <input type="file" class="btn btn-primary col-4" id="image">
                                                    <progress id="uploadProgress" value="0" max="100" style="display:none;"></progress>
                                                    <input type="hidden" id="fileData" name="fileData">
                                                    ${nextButton}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    `;

                // Modal içeriğini ekle ve göster
                $('body').append(modalContent);
                $('#QuestionModal').modal('show');


                // Fotoğraf yükleme

                $("#image").on("change", async function () {
                    const file = this.files[0];
                    if (file) {
                        this.className = "btn btn-warning col-4";
                        const formData = new FormData();
                        formData.append("file", file);
            
                        const progressBar = document.getElementById("uploadProgress");
                        progressBar.style.display = "block";
            
                        try {
                            const response = await axios.post("/upload/save", formData, {
                                onUploadProgress: function (progressEvent) {
                                    const progress = Math.round((progressEvent.loaded / progressEvent.total) * 100);
                                    progressBar.value = progress;
                                },
                            });
            
                            const imageUrl = response.data.url;
        
            
                            const imageInput = document.getElementById("fileData");
                            imageInput.value = imageUrl;
            
                            progressBar.style.display = "none";
                        } catch (error) {
                            console.log("Error uploading file:", error);
                            progressBar.style.display = "none";
                        }
                    }
                });

               
                // Next butonuna tıklama olayı
                $('#nextButton').on('click', async () => {
            
                    const answer = $('input[name="answers"]:checked').val();
                    const notes = $("#notes").val();
                    const code = $('#code').val();
                    const file = $('#fileData').val();
                    const confirmative = $('#selectAdmin').val();
                    // Soruyu kaydet ve modalı kapat
                    await this.saveQuestion(formId, questionNumber, answer, notes, draft, key, code, confirmed, confirmative, file);
                    $('#QuestionModal').remove();
                    $('.modal-backdrop').remove();
                });
            } else {
                await this.finalForm(draft, key);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    // CEVABI KAYDET
    async saveQuestion(formId, questionNumber, answer, notes, draft, key, code, confirmed, confirmative, file){
        
        await axios.post('/save/answer', {key:key, form:formId, soru:questionNumber, cevap:answer, not:notes, draft:draft, key:key, code:code, confirmed:confirmed, confirmative:confirmative, file:file}).then((res) => {
            toastr[res.data.type](res.data.message);
            questionNumber++;
            this.questionFire(formId, questionNumber, draft, key)
        });
       
    }


    // ONAY KODU GÖNDER
    async adminSelect() {
        const admin = $("#selectAdmin").val();
        const question = $("#selectAdminSoru").val();

        try {
            const confirmationResponse = await axios.post('/send-confirmation-code', { admin, question });
            const confirmationStatus = confirmationResponse.data.status;

            if (confirmationStatus) {
                const { value: code } = await Swal.fire({
                    title: "Onay kodu:",
                    text: "Seçilen yöneticiye 6 haneli bir onay kodu gönderildi. Lütfen aşağıdaki kodu girin.",
                    input: "text",
                    confirmButtonText: "Onayla",
                    showCancelButton: false,
                    allowOutsideClick: false,
                    preConfirm: async (code) => {
                        try {
                            const response = await axios.post('/control-confirmation-code', { code });
                            if (!response.data.ok) {
                                throw new Error(response.statusText);
                            }
                            $("#nextButton").attr('disabled', false);
                            $("#code").val(code)
                            return response.data;
                        } catch (error) {
                            console.log(error);
                            throw new Error(`Error: ${error}`);
                        }
                    },
                });

                if (code) {
                    // code kullanılarak yapılacak işlemler
                }
            }
        } catch (error) {
            console.log(error);
        }
    }

    async finalForm(draft, key) {
        const finalContent = `<div class="modal fade" id="FinalModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="FinalModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="FinalModal">Complete Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="modal-title mb-4" style="font-size:.8rem">Sign/Upload the Form</h4>
                        <canvas style="border:2px solid #eee; border-radius:8px"></canvas>
                    </div>
                    <div class="modal-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-danger float-end" id="trashFinalButton">Trash</button>
                        <button type="button" class="btn btn-warning float-end" id="draftFinalFormButton">Draft</button>
                        <button type="button" class="btn btn-success float-end" id="saveFinalFormButton">Finish</button>
                    </div>
                </div>
            </div>
        </div>`;
    
        $('body').append(finalContent);
        $('#FinalModal').modal('show');
    
        const canvas = document.querySelector("canvas");
        const signaturePad = new SignaturePad(canvas);
        signaturePad.minWidth = 1;
        signaturePad.maxWidth = 1;
        signaturePad.penColor = "#000";
        canvas.width = "460";
    
    
        $("#saveFinalFormButton").on("click", function () {
            const signature = signaturePad.toDataURL("image/svg+xml");
            
            axios.post('/draft/save', {draft, signature}).then((res) => {
                toastr[res.data.type](res.data.message);
                if(res.data.status){
                    setInterval(() => {
                        window.location.reload();
                    }, 1000);
                }
            });
        });
        
        $("#trashFinalButton").on("click", function(){
            $(".btn").attr('disabled', true);
            axios.post('/draft/delete', {draft:draft}).then((res) => {
                toastr[res.data.type](res.data.message);
                if(res.data.status){
                    setInterval(() => {
                        window.location.reload();
                    }, 1000);
                }
            });
        });

        $("#draftFinalFormButton").on("click", function(){
            $(".btn").attr('disabled', true);
            toastr["success"]("Form taslak olarak kaydedildi.");
            setInterval(() => {
                window.location.reload();
            }, 1000);
        });

        $("#previewImage").on("click", function () {
            const previewImage = document.getElementById("previewImage");
            previewImage.src = "";
            previewImage.style.display = "none";
    
            const imageInput = document.getElementById("imageInput");
            imageInput.value = "";
        });
    }
    
}
    


const Draft = new SurveyDraft;
