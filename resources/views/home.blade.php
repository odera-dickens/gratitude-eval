@extends('layouts.app')

@section('content')
<div class="container" id="app">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <button type="button" class="btn btn-primary btn-sm" @click="tab = 'cat'">Categories</button>
                    <button type="button" class="btn btn-primary btn-sm" @click="tab = 'exam'">Exams</button>
                    <br>
                    <br>
                    <div id="cat-container" v-show="tab === 'cat'">
                        <h3>Category Management</h3>
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-cat-modal">Add Category</button>
                            <div>
                                <div class="modal fade" id="add-cat-modal" tabindex="-1" aria-labelledby="add-cat-modal" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="add-exam-modal-label">Add Category</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="name" v-model="category_form.name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" @click="save_category()" data-dismiss="modal">Save Category</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row mb-3">
                                <div class="col-8"></div>
                                <div class="col-4">
                                    <input class="form-control form-control-sm" placeholder="Search Categories..." v-model="category_query">
                                </div>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="category in filtered_categories">
                                        <th scope="row" v-text="category.id"></th>
                                        <td v-text="category.name"></td>
                                        <td>
                                            <div class="row">
                                                <button class="btn btn-primary mr-3 btn-sm" @click="category_update_form = category" data-toggle="modal" data-target="#update-cat-modal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <div>
                                                    <div class="modal fade" id="update-cat-modal" tabindex="-1" aria-labelledby="update-cat-modal" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="add-exam-modal-label">Update Category</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group row">
                                                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" class="form-control" id="name" v-model="category_update_form.name">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary" @click="update_category()" data-dismiss="modal">Update Category</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="btn btn-warning btn-sm" @click="delete_category(category)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row mb-3 ml-2" v-if="category_groups > 1">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-secondary btn-sm" v-for="n in category_groups" v-text="n" @click="selected_cat_group = n"></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="exam-container" v-show="tab === 'exam'">
                        <div v-if="current_exam.id === 0">
                            <h3>Exam Management</h3>
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add-exam-modal">Add Exam</button>
                                <div>
                                    <div class="modal fade" id="add-exam-modal" tabindex="-1" aria-labelledby="add-exam-modal" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="add-exam-modal-label">Add Exam</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group row">
                                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Title</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="title" v-model="exam_form.title">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Duration</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="duration" v-model="exam_form.duration">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary" @click="save_exam()" data-dismiss="modal">Save Exam</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="row mb-3">
                                    <div class="col-8"></div>
                                    <div class="col-4">
                                        <input class="form-control form-control-sm" placeholder="Search Exams..." v-model="exam_query">
                                    </div>
                                </div>
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Duration</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="exam in filtered_exams">
                                        <th scope="row" v-text="exam.id"></th>
                                        <td v-text="exam.title"></td>
                                        <td v-text="exam.duration"></td>
                                        <td>
                                            <div class="row">
                                                <button class="btn btn-success mr-3 btn-sm" @click="current_exam = exam">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn btn-primary mr-3 btn-sm" @click="exam_update_form = exam" data-toggle="modal" data-target="#update-exam-modal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <div>
                                                    <div class="modal fade" id="update-exam-modal" tabindex="-1" aria-labelledby="update-exam-modal" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="add-exam-modal-label">Update Exam</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group row">
                                                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Title</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" class="form-control" id="title" v-model="exam_update_form.title">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Duration</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" class="form-control" id="duration" v-model="exam_update_form.duration">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary" @click="update_exam()" data-dismiss="modal">Update Exam</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <span></span>
                                                <button class="btn btn-warning btn-sm" @click="delete_exam(exam)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="row mb-3 ml-2" v-if="exam_groups > 1">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-secondary btn-sm" v-for="n in exam_groups" v-text="n" @click="selected_exam_group = n"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="current_exam.id !== 0">
                            @include('layouts.exam')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
