<template>
    <div class="container-fluid se-bg-table p-4">

        <div class="se-btn-panel row">
            <div class="m-2 m-md-1">
                <button class="btn btn-dark" @click="showFormAdd" title="Добавить устройство">
                    <i class="fa fa-plus-circle"></i>
                </button>
                <button class="btn btn-primary" @click="showFormEdit" title="Редактировать устройство">
                    <i class="fa fa-pencil"></i>
                </button>
                <button class="btn btn-danger" @click="remove_Device" title="Удалить устройство">
                    <i class="fa fa-trash"></i>
                </button>
            </div>

            <div class="m-2 m-md-1 ml-md-2 mr-md-2">
                <input type="text" class="form-control" title="Поле ввода" v-model="valueFind" @keydown.enter="find_Device" ref="inputFind">
            </div>

            <div class="m-2 m-md-1">
                <button class="btn btn-primary" @click="find_Device" title="Выполнить поиск">
                    <i class="fa fa-search"></i>
                </button>
                <button class="btn btn-info" @click="exportXLS" title="Экспортировать в xls">
                    <i class="fa fa-file-excel-o"></i>
                </button>
                <button class="btn" @click="showFormLogs" title="Просмотреть логи">
                    <i class="fa fa-archive"></i>
                </button>
            </div>

            <div class="m-2 m-md-1 ml-md-4">
                <ul class="pagination m-0 ml-md-3">
                    <li v-for="page in pagination" class="page-item" :class="{'active': page.num === pageActive}">
                        <a class="page-link"
                           @click="load_Devices(page.num)"
                        >{{page.title}}</a>
                    </li>
                </ul>
            </div>
        </div>

        <transition name="se-bg">
            <div v-if="isFormAdd" class="position-fixed se-bg-black">
                <!-- Modal -->
                <div class="modal-content se-form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Добавить устройство</h5>
                        <button type="button" class="close" @click="closeFormAdd">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="product">Производитель</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="product" class="form-control"
                                       :class="{'error-input': $v.printer.product.$error}"
                                       @change="$v.printer.product.$touch()"
                                       v-model="printer.product">

                                <small class="form-text text-muted" :class="{'is-error': $v.printer.product.$error}">
                                    <span v-if="!$v.printer.product.required" class="error-text"
                                          :class="{'error-show': !$v.printer.product.required}">Поле пустое</span>
                                    <span v-if="!$v.printer.product.minLength" class="error-text"
                                          :class="{'error-show': !$v.printer.product.minLength}">Минимум 4 символа</span>
                                </small>

                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="model">Модель</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="model" class="form-control"
                                       :class="{'error-input': $v.printer.model.$error}"
                                       @change="$v.printer.model.$touch()"
                                       v-model="printer.model">

                                <small class="form-text text-muted" :class="{'is-error': $v.printer.model.$error}">
                                    <span v-if="!$v.printer.model.required" class="error-text"
                                          :class="{'error-show': !$v.printer.model.required}">Поле пустое</span>
                                    <span v-if="!$v.printer.model.minLength" class="error-text"
                                          :class="{'error-show': !$v.printer.model.minLength}">Минимум 4 символа</span>
                                </small>

                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="serial">Серийный номер</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="serial" class="form-control"
                                       :class="{'error-input': $v.printer.serial.$error}"
                                       @change="$v.printer.serial.$touch()"
                                       v-model="printer.serial">

                                <small class="form-text text-muted" :class="{'is-error': $v.printer.serial.$error}">
                                    <span v-if="!$v.printer.serial.required" class="error-text"
                                          :class="{'error-show': !$v.printer.serial.required}">Поле пустое</span>
                                    <span v-if="!$v.printer.serial.minLength" class="error-text"
                                          :class="{'error-show': !$v.printer.serial.minLength}">Минимум 4 символа</span>
                                </small>

                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="mac">Mac</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="mac" class="form-control" v-model="printer.mac">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="inventory">Инвентарный</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="inventory" class="form-control"
                                       :class="{'error-input': $v.printer.inventory.$error}"
                                       @change="$v.printer.inventory.$touch()"
                                       v-model="printer.inventory">

                                <small class="form-text text-muted" :class="{'is-error': $v.printer.inventory.$error}">
                                    <span v-if="!$v.printer.inventory.required" class="error-text"
                                          :class="{'error-show': !$v.printer.inventory.required}">Поле пустое</span>
                                    <span v-if="!$v.printer.inventory.minLength" class="error-text"
                                          :class="{'error-show': !$v.printer.inventory.minLength}">Минимум 4 символа</span>
                                </small>

                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="cartridge">Картридж</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="cartridge" class="form-control" v-model="printer.cartridge">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="location">Расположение</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="location" class="form-control"
                                       :class="{'error-input': $v.printer.location.$error}"
                                       @change="$v.printer.location.$touch()"
                                       v-model="printer.location">

                                <small class="form-text text-muted" :class="{'is-error': $v.printer.location.$error}">
                                    <span v-if="!$v.printer.location.required" class="error-text"
                                          :class="{'error-show': !$v.printer.location.required}">Поле пустое</span>
                                    <span v-if="!$v.printer.location.minLength" class="error-text"
                                          :class="{'error-show': !$v.printer.location.minLength}">Минимум 4 символа</span>
                                </small>

                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="cabinet">Кабинет</label>
                            </div>
                            <div class="col-md-5">
                                <input type="number" id="cabinet" class="form-control" v-model="printer.cabinet">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="username">Пользователь</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="username" class="form-control" v-model="printer.username">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeFormAdd">Закрыть</button>
                        <button type="button" class="btn btn-primary" @click="add_Device">Добавить</button>
                    </div>
                </div>
            </div>
        </transition>

        <transition name="se-bg">
            <div v-if="isFormEdit" class="position-fixed se-bg-black">
                <!-- Modal -->
                <div class="modal-content se-form">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактировать устройство</h5>
                        <button type="button" class="close" @click="closeFormEdit">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="e_product">Производитель</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="e_product" class="form-control"
                                       :class="{'error-input': $v.getCurrentDevice.product.$error}"
                                       @change="$v.getCurrentDevice.product.$touch()"
                                       v-model="getCurrentDevice.product">

                                <small class="form-text text-muted" :class="{'is-error': $v.getCurrentDevice.product.$error}">
                                    <span v-if="!$v.getCurrentDevice.product.required" class="error-text"
                                          :class="{'error-show': !$v.getCurrentDevice.product.required}">Поле пустое</span>
                                    <span v-if="!$v.getCurrentDevice.product.minLength" class="error-text"
                                          :class="{'error-show': !$v.getCurrentDevice.product.minLength}">Минимум 4 символа</span>
                                </small>

                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="e_model">Модель</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="e_model" class="form-control"
                                       :class="{'error-input': $v.getCurrentDevice.model.$error}"
                                       @change="$v.getCurrentDevice.model.$touch()"
                                       v-model="getCurrentDevice.model">
                                <small class="form-text text-muted" :class="{'is-error': $v.getCurrentDevice.model.$error}">
                                    <span v-if="!$v.getCurrentDevice.model.required" class="error-text"
                                          :class="{'error-show': !$v.getCurrentDevice.model.required}">Поле пустое</span>
                                    <span v-if="!$v.getCurrentDevice.model.minLength" class="error-text"
                                          :class="{'error-show': !$v.getCurrentDevice.model.minLength}">Минимум 4 символа</span>
                                </small>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="e_serial">Серийный номер</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="e_serial" class="form-control"
                                       :class="{'error-input': $v.getCurrentDevice.serial.$error}"
                                       @change="$v.getCurrentDevice.serial.$touch()"
                                       v-model="getCurrentDevice.serial">

                                <small class="form-text text-muted" :class="{'is-error': $v.getCurrentDevice.serial.$error}">
                                    <span v-if="!$v.getCurrentDevice.serial.required" class="error-text"
                                          :class="{'error-show': !$v.getCurrentDevice.serial.required}">Поле пустое</span>
                                    <span v-if="!$v.getCurrentDevice.serial.minLength" class="error-text"
                                          :class="{'error-show': !$v.getCurrentDevice.serial.minLength}">Минимум 4 символа</span>
                                </small>

                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="e_mac">Mac</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="e_mac" class="form-control" v-model="getCurrentDevice.mac">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="e_inventory">Инвентарный</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="e_inventory" class="form-control"
                                       :class="{'error-input': $v.getCurrentDevice.inventory.$error}"
                                       @change="$v.getCurrentDevice.inventory.$touch()"
                                       v-model="getCurrentDevice.inventory">

                                <small class="form-text text-muted" :class="{'is-error': $v.getCurrentDevice.inventory.$error}">
                                    <span v-if="!$v.getCurrentDevice.inventory.required" class="error-text"
                                          :class="{'error-show': !$v.getCurrentDevice.inventory.required}">Поле пустое</span>
                                    <span v-if="!$v.getCurrentDevice.inventory.minLength" class="error-text"
                                          :class="{'error-show': !$v.getCurrentDevice.inventory.minLength}">Минимум 4 символа</span>
                                </small>

                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="e_cartridge">Картридж</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="e_cartridge" class="form-control" v-model="getCurrentDevice.cartridge">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="e_location">Расположение</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="e_location" class="form-control"
                                       :class="{'error-input': $v.getCurrentDevice.location.$error}"
                                       @change="$v.getCurrentDevice.location.$touch()"
                                       v-model="getCurrentDevice.location">

                                <small class="form-text text-muted" :class="{'is-error': $v.getCurrentDevice.location.$error}">
                                    <span v-if="!$v.getCurrentDevice.location.required" class="error-text"
                                          :class="{'error-show': !$v.getCurrentDevice.location.required}">Поле пустое</span>
                                    <span v-if="!$v.getCurrentDevice.location.minLength" class="error-text"
                                          :class="{'error-show': !$v.getCurrentDevice.location.minLength}">Минимум 4 символа</span>
                                </small>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="e_cabinet">Кабинет</label>
                            </div>
                            <div class="col-md-5">
                                <input type="number" id="e_cabinet" class="form-control" v-model="getCurrentDevice.cabinet">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-5 offset-1">
                                <label for="e_username">Пользователь</label>
                            </div>
                            <div class="col-md-5">
                                <input type="text" id="e_username" class="form-control" v-model="getCurrentDevice.username">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeFormEdit">Закрыть</button>
                        <button type="button" class="btn btn-primary" @click="edit_Device">Редактировать</button>
                    </div>
                </div>
            </div>
        </transition>

        <transition name="se-bg">
            <div v-show="isFormLogs" class="se-bg-black position-fixed">
            <div class="se-form-logs modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Логи (<span>{{getStartPage-1}} из {{getCountPages}}</span>). Загружено логов: {{getLogs.length}} из {{getCountLogs}}</h5>
                    <button type="button" class="close" @click="closeFormLogs">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body se-table-logs-auto-scroll" ref="frmLogs" @scroll="scrollLogs">
                    <table class="table table-striped">
                        <tr>
                            <th>Инициатор</th>
                            <th>Хост</th>
                            <th>Действие</th>
                            <th>Информация</th>
                            <th>Дата</th>
                        </tr>
<!--                        :class="{'table-active': index === getCurrentIndexDevice}"-->
                        <tr v-for="(log, index) in getLogs" :title="'Инициатор: '+log.user.name" :key="log.id" :class="{'last-el': getLogs.length -19 === index +1}">
                            <td style="cursor: pointer" @click="">{{formatName(log.user.name)}}</td>
                            <td>{{log.host}}</td>
                            <td>{{log.event.title}}</td>
                            <td>{{log.data}}</td>
                            <td>
                                <p class="mb-0">{{dateFormat(log.updated_at)}}</p>
                                <span>{{timeFormat(log.updated_at)}}</span>
                            </td>
                        </tr>
                    </table>
                    <div class="p-2 text-center">
                        <button class="btn m-2" @click="load_logs">ЗАГРУЗИТЬ ЕЩЕ..</button>
                    </div>
                </div>

                <div class="modal-footer">
                    <select
                        class="form-control"
                        @change="setColumnFind">
                        <option :value="ev.event" v-for="ev in getEvents" :key="ev.id">{{ev.title}}</option>
                    </select>
                    <input type="search" class="form-control"
                           @input="inputTextFind"
                           @keydown.esc="inputTextFind"
                           @keydown.enter="find_logs"
                           ref="inputSearchLogs">
                    <button class="btn" @click="find_logs">Искать</button>
                    <button class="btn btn-secondary" @click="closeFormLogs">Закрыть</button>

                </div>
            </div>
        </div>
        </transition>

        <div class="se-table table-responsive-md">
            <table class="table table-hover table-bordered">
                <thead>
                <tr
                    @click="selectColumn">
                    <th se-column="id">id</th>
                    <th se-column="product">Производитель</th>
                    <th se-column="model">Модель</th>
                    <th se-column="serial">Серийный №</th>
                    <th se-column="mac">Мак</th>
                    <th se-column="inventory">Инвентарный</th>
                    <th se-column="cartridge">Картридж</th>
                    <th se-column="location">Расположение</th>
                    <th se-column="cabinet">Кабинет</th>
                    <th se-column="username">Пользователь</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(p, index) in getDevices"
                    @click="selectDevice(p, index)"
                    @dblclick="showFormEdit"
                    :class="{'table-active': index === getCurrentIndexDevice}">
                    <td>{{p.id}}</td>
                    <td>{{p.product}}</td>
                    <td>{{p.model}}</td>
                    <td>{{p.serial}}</td>
                    <td>{{p.mac}}</td>
                    <td>{{p.inventory}}</td>
                    <td>{{p.cartridge}}</td>
                    <td>{{p.location}}</td>
                    <td>{{p.cabinet}}</td>
                    <td>{{p.username}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <Messenger :Messenger="Messenger"></Messenger>

    </div>
</template>

<script>
    import Messenger from "../structures/components/Messenger";
    import { required, minLength, between } from 'vuelidate/lib/validators';
    import {mapGetters, mapMutations, mapActions} from 'vuex';
    export default {

        name: "PrinterPage",

        components: {
            Messenger
        },

        data() {
            return {
                printer: {
                  id: undefined,
                  product: undefined,
                  model: undefined,
                  serial: undefined,
                  location: undefined,
                  cartridge: undefined,
                  mac: undefined,
                  inventory: undefined,
                  username: undefined,
                  cabinet: undefined
                },

                pagination: [],
                pageActive: '',

                isLoading: false,

                Messenger: {
                    text: '',
                    status: ''
                },

                isFormAdd: false,
                isFormEdit: false,
                isFormLogs: false,

                valueFind:'',

                // columnFind:'model',  //???????????

                // activeColumn:undefined //?????????????
            }
        },

        computed: {
            ...mapGetters([
                'getUser', 'getDevices',
                'getCurrentDevice', 'getCurrentIndexDevice',
                'getLogs', 'getCountPages',
                'getTextFind', 'getBackup',
                'getEvents', 'getStartPage',
                'getCountLogs'
            ])
        },

        validations: {
            printer: {
                product: {
                    required,
                    minLength: minLength(4)
                },
                model: {
                    required,
                    minLength: minLength(4)
                },

                location: {
                    required,
                    minLength: minLength(4)
                },

                serial: {
                    required,
                    minLength: minLength(4)
                },

                inventory: {
                    required,
                    minLength: minLength(4)
                }
            },

            getCurrentDevice: {
                product: {
                    required,
                    minLength: minLength(4)
                },
                model: {
                    required,
                    minLength: minLength(4)
                },

                location: {
                    required,
                    minLength: minLength(4)
                },

                serial: {
                    required,
                    minLength: minLength(4)
                },

                inventory: {
                    required,
                    minLength: minLength(4)
                }
            }
        },

        methods: {

            ...mapMutations(['resetBackupDevices', 'setCurrentDevice', 'setCurrentIndexDevice', 'setLogs', 'setTextFind', 'setColumnFind', 'setBackup', 'setStartPage']),

            ...mapActions(['loadDevices', 'addDevice', 'editDevice', 'removeDevice', 'findDevice', 'loadBackupDevices', 'loadLogs', 'loadCountPages', 'findLogs', 'loadEvents','loadCountLogs']),

            // Загрузка устройств
            load_Devices(page = 1) {

                this.pageActive = page;

                this.loadDevices(page).then(response => {

                    this.pagination = [];
                    this.pagination.push({title:'первая', num:1});

                    for (let i=1; i <= response.paginationCount; i++) {
                        if (
                            page+2 === i||page+1 === i||page-1 === i||page-2===i||
                            page===i||i === 10|| i===20||i===30||i===40||i===50||
                            i===60||i===70||i===80||i===90||i===100
                        )
                            this.pagination.push({title:i, num:i});
                    }
                    this.pagination.push({title:'последняя', num:response.paginationCount});

                    this.setCurrentIndexDevice(null);
                    this.setCurrentDevice(null);

                    this.resetBackupDevices();
                }).catch(e => {
                    console.dir(e);
                    this.Messenger = {text: e.message, status: 'error' };
                });
            },

            // Добавить устройство
            add_Device() {
                this.$v.printer.$touch();

                if (!this.$v.printer.$invalid) {

                    const pr = this.printer;

                    const formData = new FormData();
                    formData.append('product', pr.product);
                    formData.append('model',   pr.model);
                    formData.append('serial',  pr.serial);
                    formData.append('mac',     pr.mac);
                    formData.append('inventory', pr.inventory);
                    formData.append('cartridge', pr.cartridge);
                    formData.append('location', pr.location);
                    formData.append('cabinet',  pr.cabinet);
                    formData.append('username', pr.username);

                    this.addDevice(formData).then(response => {

                        if (response.result) {
                            this.Messenger = {text: 'Устройство добавлено.', status: 'success'};
                            this.setCurrentDevice(null);
                            this.isFormAdd = false;
                            this.$v.printer.$reset();
                        }

                    }).catch(e => {
                        console.dir(e);
                        this.Messenger = {text: e.message, status: 'error' };
                    });
                }  else {
                    this.Messenger = {text: 'Заполните все поля', status: 'error' };
                }
            },

            // Редактировать устройство
            edit_Device() {
                this.$v.getCurrentDevice.$touch();

                if (!this.$v.getCurrentDevice.$invalid) {

                    const device = this.getCurrentDevice;

                    const formData = new FormData();
                    formData.append('product', device.product);
                    formData.append('model',   device.model);
                    formData.append('serial',  device.serial);
                    formData.append('mac',     device.mac);
                    formData.append('inventory', device.inventory);
                    formData.append('cartridge', device.cartridge);
                    formData.append('location', device.location);
                    formData.append('cabinet',  device.cabinet);
                    formData.append('username', device.username);
                    formData.append('username', device.username);
                    formData.append("_method", "PUT"); //Обязательно, для FormData

                    // const _token = document.head.querySelector('meta[name="csrf-token"]').content;
                    // , token: _token

                    const obj = {deviceId: this.getCurrentDevice.id, formData: formData, deviceIndex: this.getCurrentIndexDevice};
                    this.editDevice(obj).then(response => {
                        if (response.result) {

                            this.setCurrentDevice(response.printer);
                            this.Messenger = {text: 'Данные обновлены!', status: 'success' };
                            this.isFormEdit = false;
                            this.$v.getCurrentDevice.$reset();
                        }
                    }).catch(e => {
                        console.dir(e);
                        this.Messenger = {text: e.message, status: 'error' };
                    });
                } else {
                    this.Messenger = {text: 'Заполните все поля', status: 'error' };
                }
            },

            // Удалить устройство
            remove_Device() {
                if (this.getCurrentIndexDevice !== null) {
                    if (confirm('Удалить выбранное устройство?')) {
                        this.removeDevice({deviceId: this.getCurrentDevice.id, deviceIndex: this.getCurrentIndexDevice}).then(response => {
                            if (response.result) {
                                this.Messenger = {text: 'Устройство удалено!', status: 'success' };

                                this.setCurrentIndexDevice(null);
                                this.setCurrentDevice(null);
                            }
                        }).catch(e => {
                            console.dir(e);
                            this.Messenger = {text: e.message, status: 'error' };
                        });
                    }
                } else {
                    this.Messenger = {text: 'Устройство не выбрано!', status: 'error' };
                }
            },

            // Поиск устройств
            find_Device() {
                this.$refs.inputFind.focus();

                if (this.valueFind.length > 0) {
                    this.findDevice({ text: this.valueFind, column: this.columnFind }).then(() => {
                        this.setCurrentDevice(null);
                        this.Messenger = {text: `Отображен результат поиска: "${this.valueFind}".`, status: 'success'};
                    }).catch(e => {
                        console.dir(e);
                        this.Messenger = {text: e.message, status: 'error' };
                    });
                } else {
                    this.loadBackupDevices();
                    this.Messenger = {text: `Поиск сброшен, отображены все записи.`, status: 'success'};
                }
            },

            showFormAdd() {
                this.Messenger = {};

                this.printer.id = undefined;
                this.printer.product = undefined;
                this.printer.model = undefined;
                this.printer.serial = undefined;
                this.printer.mac = undefined;
                this.printer.inventory = undefined;
                this.printer.cartridge = undefined;
                this.printer.location = undefined;
                this.printer.cabinet = undefined;
                this.printer.username = undefined;

                this.setCurrentDevice(null);
                this.setCurrentIndexDevice(null);

                this.isFormAdd = true;
            },

            closeFormAdd() {
                this.isFormAdd = false;
                this.Messenger = {};
                this.$v.printer.$reset();
            },

            showFormEdit() {
                if (this.getCurrentDevice) {
                    this.Messenger = {};
                    this.isFormEdit = true;
                } else {
                    this.Messenger = {text: 'Строка не выбрана', status: 'error' };
                }
            },

            closeFormEdit() {
                this.Messenger = {};
                this.isFormEdit = false;
                this.$v.getCurrentDevice.$reset();
            },

            showFormLogs() {
                this.Messenger = {};
                this.isFormLogs = true;
                this.setStartPage();

                // Загрузка логов при отображении формы
                this.load_countPage(() => this.load_logs());

                this.load_events();
                this.loadCountLogs();
            },

            closeFormLogs(){
                this.Messenger = {};
                this.isFormLogs = false;
                this.setLogs([]);
                this.setBackup([]);
            },

            selectDevice(printer, index) {
                this.setCurrentDevice(printer);
                this.setCurrentIndexDevice(index);
            },

            selectColumn(e) {
                const column = e.target;

                if (column.localName !== 'th') return;

                this.columnFind = column.getAttribute('se-column');
                const columns = document.querySelectorAll('table tr th');
                columns.forEach(item => {
                    if (item.classList.contains('se-active-column')) {
                        item.classList.remove('se-active-column');
                    }
                });
                column.classList.add('se-active-column');
            },

            exportXLS() {
                if (confirm('Экспортировать в xls?')) {
                    const url = `/api/device/export-xls`;
                    axios.get(url).then(response => {
                        window.open(response.data.filename);
                    }).catch(e => {
                        console.dir(e);
                        this.Messenger = {text: e.message, status: 'error' };
                    });
                }
            },

            // Загрузка логов при скролинге
            scrollLogs() {
                const bottom = 200;
                const frmLogs = this.$refs.frmLogs;

                if ((frmLogs.scrollHeight - frmLogs.scrollTop) - bottom <= frmLogs.clientHeight && !this.isLoading) {
                    this.load_logs();
                }
            },

            scrollToTopComments() {
                const element = this.$el.querySelector(".last-el");//.offset.top;
                if (element) element.scrollIntoView();

                // console.dir(element)
                // element.scrollTop = 0;
                // element.scrollHeight;
                // element.scrollTo();
                // document.body.scrollTop(element);

            },

            // Загрузка логов
            load_logs() {
                // if (this.getCountPages <= 0) return;

                this.isLoading = true;

                this.loadLogs().then(() => {
                    this.isLoading = false;
                    this.scrollToTopComments();
                }).catch(e => {
                    console.dir(e);
                    this.Messenger = {text: e.message, status: 'error' };
                });
            },

            // Кол-во страниц логов
            load_countPage(func_limitGetLogs) {
                this.loadCountPages().then(response => {

                    if (func_limitGetLogs !== undefined)
                        func_limitGetLogs();

                }).catch(e => {
                    console.dir(e);
                    this.Messenger = {text: e.message, status: 'error' };
                })
            },

            // Загрузка логов
            // limitGetLogs() {
            //     if (this.logsPage <= 0) return;
            //
            //     const url = `/api/log/limit-gets/${this.logsPage}`;
            //     this.isLoading = true;
            //
            //     axios.get(url).then(response => {
            //         const logs = response.data.logs;
            //
            //         // Если элементоов меньше 8, то загружаем еще пачку
            //         if (logs.length < 8) {
            //             this.logsPage--;
            //             this.limitGetLogs();
            //         }
            //
            //         if (logs.length <= 0)
            //             return;
            //
            //         for (let log of logs) {
            //             this.logs.push(log);
            //         }
            //
            //         this.logsPage--;
            //
            //     }).catch(error => {
            //
            //     }).finally(() => {
            //         this.isLoading = false;
            //     });
            // },

            // Кол-во страниц логов
            // getCountPage(func_limitGetLogs) {
            //
            //     const url = `/api/log/count-page`;
            //     axios.get(url).then(response => {
            //         this.logsPage = response.data.count;
            //     }).catch(error => {
            //
            //     }).finally(() => {
            //         if (func_limitGetLogs !== undefined) {
            //             func_limitGetLogs();
            //         }
            //     });
            // },

            // Поиск логов
            inputTextFind(e) {

                this.setTextFind(e.target.value.trim());

                if (this.getTextFind.length === 0) {
                    if (this.getBackup.length > 0) {
                        this.setLogs(this.getBackup);
                        this.setBackup([]);
                        this.Messenger = {text: `Поиск сброшен, отображены все записи.`, status: 'success'};
                    }
                }
            },

            find_logs() {

                this.$refs.inputSearchLogs.focus();

                if (this.getTextFind.length < 5) {
                    this.Messenger = {text: 'Для поиска необходимо ввести 5 символов.', status: 'error'};
                    return false;
                }

                this.findLogs().then(response => {

                }).catch(e => {
                    console.dir(e);
                    this.Messenger = {text: e, status: 'error'}
                });

                // if (this.valueFindLogs.length < 5) {
                //     this.Messenger = {text: 'Для поиска необходимо ввести 5 символов.', status: 'error'};
                //     return false;
                // }
                // const url = `/api/log/find/text/${this.valueFindLogs}/type/${this.typeFindLogs}`;
                // axios.get(url).then(response => {
                //     if (this.logsBackup.length === 0) {
                //         this.logsBackup = this.logs;
                //     }
                //     this.logs = response.data.logs;
                // }).catch(error => {
                //     this.Messenger = {text: error, status: 'error'}
                // });
            },

            dateFormat(date) {
                const d = new Date(date);
                const dtf = new Intl.DateTimeFormat('ru', { year: 'numeric', month: '2-digit', day: '2-digit' });
                const [{ value: da },,{ value: mo },,{ value: ye }] = dtf.formatToParts(d);
                const str = `${da}.${mo}.${ye}`;
                return str;
            },

            timeFormat(datetime) {
                const dtf = new Intl.DateTimeFormat('ru-RU', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                const [{ value: h },,{ value: m },,{ value: s }] = dtf.formatToParts(new Date(datetime));
                return `${h}:${m}:${s}`;

                // let hours = d.getHours();
                // let minutes = d.getMinutes();
                // let ampm = hours >= 12 ? 'pm' : 'am';
                // hours = hours % 12;
                // hours = hours ? hours : 12; // the hour '0' should be '12'
                // minutes = minutes < 10 ? '0'+minutes : minutes;
                // let strTime = hours + ':' + minutes + ' ' + ampm;
                // return strTime;
            },

            formatName(username) {
                const  name = username.split(' ');
                let i = 0;
                let n = '';

                name.forEach(item => {
                    if (i !== 0)
                        n += `${item.slice(0,1)}. `;
                    else
                        n = `${item} `;
                    i++;
                });
                return n;
            },

            load_events() {
                this.loadEvents();
            }
        },

        mounted() {
            if (!this.getUser.auth) {
                this.$router.push('/auth');
            }

            this.load_Devices();
        }
    }
</script>

<style lang="scss" scoped>

    .last-el{
        background-color: #d2d3f9;
    }

    /*Фон таблицы*/
    .se-bg-table {
        background: #dedede;
        border: solid 1px #e0e0e2;
    }

    /*Фон всплывающей формы*/
    .se-bg-black {
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        background: #000000ab;
        padding: 25px;
        z-index: 2;
        display: flex;
    }

    /*Обычная форма*/
    .se-form {
        max-width: 750px;
        margin: auto;
        overflow: auto;
        height: 100%;
    }

    /*Форма логов*/
    .se-form-logs {
        max-width: 1800px;
        margin: auto;
        overflow: auto;
        height: 100%;

        table{
            td, th {
                padding: 4px;
            }
        }

        .se-table-logs-auto-scroll {
            overflow: auto;
        }
    }

    /*Таблица*/
    .se-table {
        font-size: 14px;
        overflow: auto;

        margin-left: -25px;
        margin-right: -25px;

        min-height: 750px;
        td, th{
            cursor: pointer;
        }
        tr {
            user-select: none;
        }

        .se-active-column {
            background: #d94747;
            color: #fefefe;
            outline: #0c5460 1px solid;
            user-select: none;
        }
    }

    /*Панель управления, кнопки*/
    .se-btn-panel {
        position: sticky;
        top: 0;
        background: #c9c9c9;
        padding: 15px;
        /*border-radius: 4px;*/
        border: solid 1px #b3b3b3;

        margin-top: -27px;
        margin-right: -26px;
        margin-left: -26px;

        user-select: none;
        button {
            margin-right: 4px;
        }
    }

</style>

<style lang="scss" scoped>
    .se-bg-enter-active {
        animation: .6s se-bg ease-in;
    }

    .se-bg-leave-active {
        animation: .5s se-bg ease-in reverse;
    }


    @keyframes se-bg {
        0% {
            opacity: 0;
            width: 0;
            transform: scale(0);
        }

        50%{
            opacity: .5;
            width: 50%;
            transform: scale(1.5);
        }

        100%{
            opacity: 1;
            width: 100%;
            transform: scale(1);
        }
    }
</style>
