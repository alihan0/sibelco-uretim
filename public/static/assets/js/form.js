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
                                                    <h5 class="modal-title" id="QuestionModal">Soru: ${soruData.align}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <span style="font-weight:bold; font-size:1.3rem">${soruData.title}</span>
                                                    <hr>
                                                    <div class="form-check mb-4">
                                                        <input class="problemExists" type="radio" name="answers" id="problemExists" value="0">
                                                        <label for="problemExists">Sorun Var</label>
                                                    </div>
                                                    <div class="form-check mb-4">
                                                        <input type="radio" name="answers" id="problemNotExists" value="1" checked>
                                                        <label for="problemNotExists">Sorun Yo</label>
                                                    </div>
                                                    ${requiredConfirm}
                                                    <input type="hidden" id="code">
                                                </div>
                                                <div class="modal-footer d-flex justify-content-between">
                                                    <input type="text" class="form-control col-8 note" placeholder="Notlar" id="notes">
                                                    ${nextButton}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    `;

                // Modal içeriğini ekle ve göster
                $('body').append(modalContent);
                $('#QuestionModal').modal('show');

               
                // Next butonuna tıklama olayı
                $('#nextButton').on('click', async () => {
            
                    const answer = $('input[name="answers"]:checked').val();
                    const notes = $("#notes").val();
                    const code = $('#code').val();
                    const confirmative = $('#selectAdmin').val();
                    // Soruyu kaydet ve modalı kapat
                    await this.saveQuestion(formId, questionNumber, answer, notes, draft, key, code, confirmed, confirmative);
                    $('#QuestionModal').remove();
                    $('.modal-backdrop').remove();
                });
            } else {
                alert('It was the last question.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    
    // CEVABI KAYDET
    async saveQuestion(formId, questionNumber, answer, notes, draft, key, code, confirmed, confirmative){
        
        await axios.post('/save/answer', {key:key, form:formId, soru:questionNumber, cevap:answer, not:notes, draft:draft, key:key, code:code, confirmed:confirmed, confirmative:confirmative}).then((res) => {
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

    async finalForm(draft, key){

    }
}
    


const Draft = new SurveyDraft;
