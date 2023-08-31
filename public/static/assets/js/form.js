class SurveyDraft {

    // FORMU BAŞLAT
    async startForm(form_id) {
        const facilities = JSON.parse($("#facilities").val());
    
        const modalContent = document.createElement('div');
        const selectElement = document.createElement('select');
        selectElement.id = 'facilitySelect';
        selectElement.classList.add('form-control');
        
        const defaultOption = document.createElement('option');
        defaultOption.value = 0;
        defaultOption.textContent = 'Tesis Seçin...';
        selectElement.appendChild(defaultOption);
    
        facilities.forEach(facility => {
            const facilityGroup = document.createElement('optgroup');
            facilityGroup.label = facility.title;
    
            facility.units.forEach(unit => {
                const option = document.createElement('option');
                option.value = unit.id;
                option.textContent = unit.title;
                facilityGroup.appendChild(option);
            });
    
            selectElement.appendChild(facilityGroup);
        });
    
        const modal = document.createElement('div');
        modal.classList.add('modal', 'fade');
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hangi Tesis veya Birim Bakıma Alınıyor?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ${selectElement.outerHTML}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="modalConfirm" disabled>Devam Et</button>
                    </div>
                </div>
            </div>
        `;
    
        document.body.appendChild(modal);
        $('#modalConfirm').on('click', async () => {
            const selectedValue = $('#facilitySelect').val();
            if (selectedValue === '0') {
                return; // Do nothing if the default option is selected
            }
            const tesis_id = selectedValue;
    
            // İkinci Modal: Tesis durumu seçimi
            // Burada ikinci bir modal oluşturabilirsiniz.
    
            // Diğer işlemleri burada yapabilirsiniz.
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
            $(modal).modal('hide');
            const question = await this.questionFire(form_id, 1, data.draft, data.key);
        });
    
        $('#facilitySelect').on('change', () => {
            const selectedValue = $('#facilitySelect').val();
            $('#modalConfirm').prop('disabled', selectedValue === '0');
        });
    
        $(modal).modal('show');
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
                                                        <input class="problemExists radio" type="radio" name="answers" id="problemExists" value="0">
                                                        <label class="radio-label" for="problemExists">Sorun Var</label>
                                                    </div>
                                                    <div class="form-check mb-4">
                                                        <input class="radio" type="radio" name="answers" id="problemNotExists" value="1" checked>
                                                        <label class="radio-label" for="problemNotExists">Sorun Yok</label>
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
                    $('#nextButton').attr("disabled", true);
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
        if(answer == 0){
            await axios.post('/find/subform', {formId:formId, questionNumber:questionNumber, key:key}).then((res) => {
                if(res.data.status){
                    toastr["warning"]("Alt Form Görevi Eklendi!");
                }
            })
        }
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
        var tasks = [];
        var taskline = "";
        await axios.post('/find-subform-task', { key:key }).then((res) => {
            res.data.subforms.forEach(element => {
                tasks.push(element)
            });
        });

        

        const finalContent = `<div class="modal fade" id="FinalModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="FinalModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="FinalModal">Formu Tamamla</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <div class="buttons"></div>
                        <h4 class="modal-title mb-4" style="font-size:.8rem">Formu İmzala</h4>
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


        $('.buttons').append('<h4 class="modal-title mb-4" style="font-size:.8rem">Alt Form Görevleri</h4>');
        tasks.forEach((task, index) => {
            const taskButton = document.createElement('button');
            taskButton.textContent = task.sub_form.title;
            taskButton.classList.add('btn', 'btn-primary', 'mr-2', 'mb-4', 'taskButton');
            taskButton.setAttribute("id", task.subform);


            $('.buttons').append(taskButton);
            $(".buttons").addClass('mb-4 border-bottom');
    
        });


        $(".taskButton").on("click", function(){
            const subformId = $(this).attr('id');
            //alert(subformId);
            var result = openSubFormModal(subformId, key);
            if(result){
                $(this).addClass('btn-success').attr('disabled',true);
            }
        })
    
    
    
    
        $("#saveFinalFormButton").on("click", function () {
            const signature = signaturePad.toDataURL("image/svg+xml");
            $("#saveFinalFormButton").attr("disabled", true);
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
    }
    
}
 

async function openSubFormModal(subformId, key) {
    try {
        const response = await axios.post('/find/subform-questions', { subformId });
        const questions = response.data.questions;

        let questionListHTML = '';

        questions.forEach(question => {
            questionListHTML += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>${question.question}</span>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="soru_${question.id}" data-question-id="${question.id}" id="evet_${question.id}" value="0">
                            <label class="form-check-label" for="evet_${question.id}">
                                Sorun Var
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="soru_${question.id}" data-question-id="${question.id}" id="hayir_${question.id}" value="1" checked>
                            <label class="form-check-label" for="hayir_${question.id}">
                                Sorun Yok
                            </label>
                        </div>
                    </div>
                </li>`;
        });

        const modal = `
            <div class="modal fade bg-dark" id="subformModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="FinalModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Alt Form</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group">
                                <form id="subFormCevaplar">
                                    ${questionListHTML}
                                </form>
                            </ul>
                        </div>
                        <div class="modal-footer d-flex justify-content-end">
                            <button type="button" class="btn btn-success float-end" id="saveSubform">Kaydet</button>
                        </div>
                    </div>
                </div>
            </div>`;

        // Modalı görünür hale getir
        $(modal).modal('show');

        // Modal kapatıldığında dinleyiciyi temizle
        $("#subformModal").on("hidden.bs.modal", function () {
            $(document).off("click", "#saveSubform");
        });

        // Kaydet butonuna click dinleyicisi ekle (DİKKAT: await kullanılmadan)
        $(document).on("click", "#saveSubform", function() {
            $(document).off("click", "#saveSubform"); // Dinleyiciyi kaldır

            var formData = {};

            $(".form-check-input:checked").each(function() {
                var questionId = $(this).data("question-id");
                formData[`soru_${questionId}`] = $(this).val();

                console.log("soru_"+questionId +" : "+ $(this).val())
            });

            axios.post('/save/subform-answers', { formData, subformId, key }).then((res) => {
                if (res.data.status) {
                    $("#subformModal").modal('hide').remove();
                    formData = {};
                    return true;
                }
            });
        });
    } catch (error) {
        console.error('Bir hata oluştu:', error);
    }
}





const Draft = new SurveyDraft;
