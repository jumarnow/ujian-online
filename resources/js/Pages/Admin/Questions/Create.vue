<template>
    <Head>
        <title>Tambah Soal Ujian - Aplikasi Ujian Online</title>
    </Head>
    <div class="container-fluid mb-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <Link :href="`/admin/exams/${exam.id}`" class="btn btn-md btn-primary border-0 shadow mb-3" type="button"><i class="fa fa-long-arrow-alt-left me-2"></i> Kembali</Link>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fa fa-question-circle"></i> Tambah Soal Ujian</h5>
                        <hr>
                        <form @submit.prevent="submit">
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-centered table-nowrap mb-0 rounded">
                                    <tbody>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Soal</td>
                                            <td>
                                                <label for="">Tipe Soal : </label>&nbsp;
                                                <span>
                                                    <input type="radio" name="tipe" value="PG" v-model="form.tipe" @change="handleRadioChange('PG')">
                                                    <span class="badge bg-info"> PG</span>&nbsp;
                                                    <input type="radio" name="tipe" value="PG Komplek" v-model="form.tipe" @change="handleRadioChange('PG Komplek')">
                                                    <span class="badge bg-secondary"> PG Komplek</span>
                                                </span>
                                                <Editor
                                                    api-key="nheg94q0w5i3bjbj5gottq1mrmrd3fnhdh7cm7mmcx3nkbhq"
                                                    v-model="form.question"
                                                    :init="{
                                                        menubar: false,
                                                        plugins: 'lists link image emoticons',
                                                        toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons'
                                                    }"
                                                />
                                                <input type="file" class="form-control mt-2" @change="handleQuestionUpload($event)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Pilihan A</td>
                                            <td>
                                                <Editor
                                                    api-key="no-api-key"
                                                    v-model="form.option_1"
                                                    :init="{
                                                        height: 130,
                                                        menubar: false,
                                                        plugins: 'lists link image emoticons',
                                                        toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons'
                                                    }"
                                                />
                                                <input type="file" class="form-control mt-2" @change="handleOptionA($event)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Pilihan B</td>
                                            <td>
                                                <Editor
                                                    api-key="no-api-key"
                                                    v-model="form.option_2"
                                                    :init="{
                                                        height: 130,
                                                        menubar: false,
                                                        plugins: 'lists link image emoticons',
                                                        toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons'
                                                    }"
                                                />
                                                <input type="file" class="form-control mt-2" @change="handleOptionB($event)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Pilihan C</td>
                                            <td>
                                                <Editor
                                                    api-key="no-api-key"
                                                    v-model="form.option_3"
                                                    :init="{
                                                        height: 130,
                                                        menubar: false,
                                                        plugins: 'lists link image emoticons',
                                                        toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons'
                                                    }"
                                                />
                                                <input type="file" class="form-control mt-2" @change="handleOptionC($event)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Pilihan D</td>
                                            <td>
                                                <Editor
                                                    api-key="no-api-key"
                                                    v-model="form.option_4"
                                                    :init="{
                                                        height: 130,
                                                        menubar: false,
                                                        plugins: 'lists link image emoticons',
                                                        toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons'
                                                    }"
                                                />
                                                <input type="file" class="form-control mt-2" @change="handleOptionD($event)">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%" class="fw-bold">Jawaban Benar <br> <span :hidden="form.isMultiple == false"> (Pilih dua jawaban benar)</span></td>
                                            <td>
                                                <select class="form-control" :multiple="form.isMultiple" v-model="form.answer">
                                                    <option value="1">A</option>
                                                    <option value="2">B</option>
                                                    <option value="3">C</option>
                                                    <option value="4">D</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <button type="submit" class="btn btn-md btn-primary border-0 shadow me-2">Simpan</button>
                            <button type="reset" class="btn btn-md btn-warning border-0 shadow">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import layout
    import LayoutAdmin from '../../../Layouts/Admin.vue';

    //import Heade and Link from Inertia
    import {
        Head,
        Link
    } from '@inertiajs/inertia-vue3';

    //import reactive from vue
    import { reactive } from 'vue';

    //import inerita adapter
    import { Inertia } from '@inertiajs/inertia';

    //import sweet alert2
    import Swal from 'sweetalert2';

    //import tinyMCE
    import Editor from '@tinymce/tinymce-vue';

    export default {

        //layout
        layout: LayoutAdmin,

        //register components
        components: {
            Head,
            Link,
            Editor,
        },

        //props
        props: {
            errors: Object,
            exam: Object,
        },

        //inisialisasi composition API
        setup(props) {

            //define form with reactive
            const form = reactive({
                question: '',
                question_img: '',
                option_1: '',
                option_1_img: '',
                option_2: '',
                option_2_img: '',
                option_3: '',
                option_3_img: '',
                option_4: '',
                option_4_img: '',
                answer: '',
                tipe: '',
                isMultiple: false // Inisialisasi atribut multiple
            });

            const handleQuestionUpload = (event) => {
                // console.log(event);
                const selectedFile = event.target.files[0];
                form.question_img = selectedFile.name;

                const formData = new FormData();
                formData.append('tipe', 'question');
                formData.append('exam_id', props.exam.id);
                formData.append('file', selectedFile);

                Inertia.post(`/admin/exams_upload_image`, formData, {
                    onSuccess: () => {
                        console.log('Gambar berhasil disimpan');
                    },
                    onError: (error) => {
                        console.error('Error uploading image:', error);
                    }
                })
            }

            const handleOptionA = (event) => {
                const selectedFile = event.target.files[0];
                form.option_1_img = selectedFile.name;

                const formData = new FormData();
                formData.append('tipe', 'option');
                formData.append('exam_id', props.exam.id);
                formData.append('file', selectedFile);

                Inertia.post(`/admin/exams_upload_image`, formData, {
                    onSuccess: () => {
                        console.log('Gambar berhasil disimpan');
                    },
                    onError: (error) => {
                        console.error('Error uploading image:', error);
                    }
                })
            }

            const handleOptionB = (event) => {
                const selectedFile = event.target.files[0];
                form.option_2_img = selectedFile.name;

                const formData = new FormData();
                formData.append('tipe', 'option');
                formData.append('exam_id', props.exam.id);
                formData.append('file', selectedFile);

                Inertia.post(`/admin/exams_upload_image`, formData, {
                    onSuccess: () => {
                        console.log('Gambar berhasil disimpan');
                    },
                    onError: (error) => {
                        console.error('Error uploading image:', error);
                    }
                })
            }

            const handleOptionC = (event) => {
                const selectedFile = event.target.files[0];
                form.option_3_img = selectedFile.name;

                const formData = new FormData();
                formData.append('tipe', 'option');
                formData.append('exam_id', props.exam.id);
                formData.append('file', selectedFile);

                Inertia.post(`/admin/exams_upload_image`, formData, {
                    onSuccess: () => {
                        console.log('Gambar berhasil disimpan');
                    },
                    onError: (error) => {
                        console.error('Error uploading image:', error);
                    }
                })
            }

            const handleOptionD = (event) => {
                const selectedFile = event.target.files[0];
                form.option_4_img = selectedFile.name;

                const formData = new FormData();
                formData.append('tipe', 'option');
                formData.append('exam_id', props.exam.id);
                formData.append('file', selectedFile);

                Inertia.post(`/admin/exams_upload_image`, formData, {
                    onSuccess: () => {
                        console.log('Gambar berhasil disimpan');
                    },
                    onError: (error) => {
                        console.error('Error uploading image:', error);
                    }
                })
            }


            const handleRadioChange = (inputTipe) => {
                if (inputTipe === 'PG Komplek') {
                    form.isMultiple = true;
                } else {
                    form.isMultiple = false;
                }
            }

            const submit = () => {
                Inertia.post(`/admin/exams/${props.exam.id}/questions/store`, {
                    question: form.question,
                    question_img: form.question_img,
                    option_1: form.option_1,
                    option_1_img: form.option_1_img,
                    option_2: form.option_2,
                    option_2_img: form.option_2_img,
                    option_3: form.option_3,
                    option_3_img: form.option_3_img,
                    option_4: form.option_4,
                    option_4_img: form.option_4_img,
                    answer: form.answer,
                    tipe: form.tipe,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Soal Ujian Berhasil Disimpan!.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });

            }

            //return
            return {
                form,
                handleQuestionUpload,
                handleRadioChange,
                handleOptionA,
                handleOptionB,
                handleOptionC,
                handleOptionD,
                submit,
            };

        }

    }

</script>

<style>

</style>
