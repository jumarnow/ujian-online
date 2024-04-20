<template>
    <Head>
        <title>Ujian Dengan Nomor Soal : {{ page }} - Aplikasi Ujian Online</title>
    </Head>
    <div class="row mb-5">
        <div class="col-md-7">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="mb-0">Soal No. <strong class="fw-bold">{{ page }}</strong> &nbsp;
                                <span :class="{
                                    'badge': true,
                                    'bg-success': question_active.question.tipe === 'PG',
                                    'bg-info': question_active.question.tipe === 'PG Komplek'
                                }" v-html="question_active.question.tipe"></span>
                            </h5>
                        </div>
                        <div>
                            <span class="badge bg-info p-2"> <i class="fa fa-clock"></i>
                                    <VueCountdown :time="duration" @progress="handleChangeDuration" @end="showModalEndTimeExam = true" v-slot="{ hours, minutes, seconds }">
                                        <span class="badge bg-info p-2"> <i class="fa fa-clock"></i> {{ hours }} jam,
                                            {{ minutes }} menit, {{ seconds }} detik.</span>
                            </VueCountdown>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div v-if="question_active !== null">

                        <div>
                            <img v-if="question_active.question.question_img" :src="`/exam_img/${question_active.question.exam.id}/question/${question_active.question.question_img}`" width="200" alt="">
                            <p v-html="question_active.question.question"></p>
                        </div>

                        <table>
                            <tbody v-if="question_active.question.tipe == 'PG Komplek'">
                                <tr v-for="(answer, index) in answer_order" :key="index">
                                    <td width="50" style="padding: 10px;">
                                        <input type="checkbox" v-model="checkedValues[answer]" :value="answer" @change="submitAnswer(question_active.question.exam.id, question_active.question.id, answer, 'PG Komplek')" />
                                    </td>
                                    <td style="padding: 10px;">
                                        <img v-if="question_active.question['option_'+answer+'_img']" :src="`/exam_img/${question_active.question.exam.id}/option/${question_active.question['option_'+answer+'_img']}`" width="200" alt="">
                                        <p v-html="question_active.question['option_'+answer]"></p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(answer, index) in answer_order" :key="index">
                                    <td width="50" style="padding: 10px;">
                                        <button v-if="answer == question_active.answer" class="btn btn-info btn-sm w-100 shadow">{{ options[index] }}</button>
                                        <button v-else @click.prevent="submitAnswer(question_active.question.exam.id, question_active.question.id, answer, 'PG')" class="btn btn-outline-info btn-sm w-100 shdaow">{{ options[index] }}</button>
                                    </td>
                                    <td style="padding: 10px;">
                                        <img v-if="question_active.question['option_'+answer+'_img']" :src="`/exam_img/${question_active.question.exam.id}/option/${question_active.question['option_'+answer+'_img']}`" width="200" alt="">
                                        <p v-html="question_active.question['option_'+answer]"></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                    <div v-else>
                        <div class="alert alert-danger border-0 shadow">
                            <i class="fa fa-exclamation-triangle"></i> Soal Tidak Ditemukan!.
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div class="text-start">
                            <button type="button" @click.prevent="prevPage" class="btn btn-gray-400 btn-sm btn-block mb-2">Sebelumnya</button>
                        </div>
                        <div class="text-end">
                            <button v-if="page < Object.keys(all_questions).length" type="button" @click.prevent="nextPage" class="btn btn-gray-400 btn-sm">Selanjutnya</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card border-0 shadow">
                <div class="card-header text-center">
                    <div class="badge bg-success p-2"> {{ question_answered }} dikerjakan</div>
                </div>
                <div class="card-body" style="height: 330px;overflow-y: auto">

                    <div v-for="(question, index) in all_questions" :key="index">
                        <div width="20%" style="width: 20%; float: left;">
                            <div style="padding: 5px;">

                                <button @click="clickQuestion(index)" v-if="index+1 == page" class="btn btn-gray-400 btn-sm w-100">{{ index + 1 }}</button>

                                <button @click="clickQuestion(index)" v-if="index+1 != page && question.answer == 0" class="btn btn-outline-info btn-sm w-100">{{ index + 1 }}</button>

                                <button @click="clickQuestion(index)" v-if="index+1 != page && question.answer != 0" class="btn btn-info btn-sm w-100">{{ index + 1 }}</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <button @click="showModalEndExam = true" class="btn btn-danger btn-md border-0 shadow w-100">Akhiri Ujian</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal akhiri ujian -->
    <div v-if="showModalEndExam" class="modal fade" :class="{ 'show': showModalEndExam }" tabindex="-1" aria-hidden="true" style="display:block;" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Akhiri Ujian ?</h5>
                </div>
                <div class="modal-body">
                    Setelah mengakhiri ujian, Anda tidak dapat kembali ke ujian ini lagi. Yakin akan mengakhiri ujian?
                </div>
                <div class="modal-footer">
                    <button @click.prevent="endExam" type="button" class="btn btn-primary">Ya, Akhiri</button>
                    <button @click.prevent="showModalEndExam = false" type="button" class="btn btn-secondary">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal waktu ujian berakhir -->
    <div v-if="showModalEndTimeExam" class="modal fade" :class="{ 'show': showModalEndTimeExam }" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" style="display:block;" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Waktu Habis !</h5>
                </div>
                <div class="modal-body">
                    Waktu ujian sudah berakhir!. Klik <strong class="fw-bold">Ya</strong> untuk mengakhiri ujian.
                </div>
                <div class="modal-footer">
                    <button @click.prevent="endExam" type="button" class="btn btn-primary">Ya</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
//import layout student
import LayoutStudent from '../../../Layouts/Student.vue';

//import Head and Link from Inertia
import {
    Head,
    Link
} from '@inertiajs/inertia-vue3';

//import ref
import {
    ref
} from 'vue';

//import VueCountdown
import VueCountdown from '@chenfengyuan/vue-countdown';
import axios from 'axios';

//import inertia adapter
import {
    Inertia
} from '@inertiajs/inertia';

import Swal from 'sweetalert2';


export default {
    //layout
    layout: LayoutStudent,

    //register components
    components: {
        Head,
        Link,
        VueCountdown
    },

    //props
    props: {
        id: Number,
        page: Number,
        exam_group: Object,
        all_questions: Array,
        question_answered: Number,
        question_active: Object,
        answer_order: Array,
        duration: Object,
        checkedValues: {
            type: Array,
            default: () => []
        }
    },

    //composition API
    setup(props) {

        //define options for answer
        let options = ["A", "B", "C", "D"];

        //define state counter
        const counter = ref(0);
        const duration = ref(props.duration.duration);

        //handleChangeDuration
        const handleChangeDuration = (() => {
            //decrement duration
            duration.value = duration.value - 1000;

            //increment counter
            counter.value = counter.value + 1;

            //cek jika durasi di atas 0
            if (duration.value > 0) {

                //...

                //update duration if 10 seconds
                if (counter.value % 10 == 1) {

                    //update duration
                    axios.put(`/student/exam-duration/update/${props.duration.id}`, {
                        duration: duration.value
                    })

                }

            }
            //...

        })

        const prevPage = (() => {

            //update duration
            axios.put(`/student/exam-duration/update/${props.duration.id}`, {
                duration: duration.value
            });

            //redirect to prevPage
            Inertia.get(`/student/exam/${props.id}/${props.page - 1}`);
        })


        const nextPage = (() => {
            //update duration
            axios.put(`/student/exam-duration/update/${props.duration.id}`, {
                duration: duration.value
            });

            //redirect to nextPage
            Inertia.get(`/student/exam/${props.id}/${props.page + 1}`);

        })

        const clickQuestion = ((index) => {
            //update duration
            axios.put(`/student/exam-duration/update/${props.duration.id}`, {
                duration: duration.value
            });

            //redirect to questin
            Inertia.get(`/student/exam/${props.id}/${index + 1}`);
        })

        const submitAnswer = ((exam_id, question_id, answer, tipe_soal) => {

            Inertia.post('/student/exam-answer', {
                exam_id: exam_id,
                exam_session_id: props.exam_group.exam_session.id,
                question_id: question_id,
                answer: answer,
                tipe_soal: tipe_soal,
                checkedValues: props.checkedValues,
                duration: duration.value
            });
        })

        //define state modal
const showModalEndExam      = ref(false);
const showModalEndTimeExam  = ref(false);

const endExam = (() => {

//...

Inertia.post('/student/exam-end', {
    exam_group_id: props.exam_group.id,
    exam_id: props.exam_group.exam.id,
    exam_session_id: props.exam_group.exam_session.id,
});

//show success alert
Swal.fire({
    title: 'Success!',
    text: 'Ujian Selesai!.',
    icon: 'success',
    showConfirmButton: false,
    timer: 4000
});

})
        //return
        return {
            options,
            duration,
            handleChangeDuration,
            prevPage,
            nextPage,
            clickQuestion,
            submitAnswer,
            showModalEndExam,
            showModalEndTimeExam,
            endExam,
        }

    }
}
</script>
