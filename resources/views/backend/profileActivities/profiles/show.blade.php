@extends('backend.layouts.app')

@section('content')
    <style>
        .navbar-nav {
            display: inherit !important;
        }
        .header__btn {
            transition-property: all;
            transition-duration: 0.2s;
            transition-timing-function: linear;
            transition-delay: 0s;
            padding: 10px 20px;
            display: inline-block;
            margin-right: 10px;
            background-color: #fff;
            border: 1px solid #2c2c2c;
            border-radius: 3px;
            cursor: pointer;
            outline: none;
        }

        .header__btn:last-child {
            margin-right: 0;
        }

        .header__btn:hover,
        .header__btn.js-active {
            color: #fff;
            background-color: #2c2c2c;
        }

        .header {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
        }

        .header__title {
            margin-bottom: 30px;
            font-size: 2.1rem;
        }

        .content__title {
            margin-bottom: 40px;
            font-size: 20px;
            text-align: center;
        }

        .content__title--m-sm {
            margin-bottom: 10px;
        }

        .multisteps-form__progress {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(0, 1fr));
        }

        .multisteps-form__progress-btn {
            transition-property: all;
            transition-duration: 0.15s;
            transition-timing-function: linear;
            transition-delay: 0s;
            position: relative;
            padding-top: 20px;
            color: rgba(108, 117, 125, 0.7);
            text-indent: -9999px;
            border: none;
            background-color: transparent;
            outline: none !important;
            cursor: pointer;
        }

        @media (min-width:500px) {
            .multisteps-form__progress-btn {
                text-indent: 0;
            }
        }

        .multisteps-form__progress-btn:before {
            position: absolute;
            top: 0;
            left: 50%;
            display: block;
            width: 13px;
            height: 13px;
            content: '';
            -webkit-transform: translateX(-50%);
            transform: translateX(-50%);
            transition: all 0.15s linear 0s, -webkit-transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
            transition: all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
            transition: all 0.15s linear 0s, transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s, -webkit-transform 0.15s cubic-bezier(0.05, 1.09, 0.16, 1.4) 0s;
            border: 2px solid currentColor;
            border-radius: 50%;
            background-color: #fff;
            box-sizing: border-box;
            z-index: 3;
        }

        .multisteps-form__progress-btn:after {
            position: absolute;
            top: 5px;
            left: calc(-50% - 13px / 2);
            transition-property: all;
            transition-duration: 0.15s;
            transition-timing-function: linear;
            transition-delay: 0s;
            display: block;
            width: 100%;
            height: 2px;
            content: '';
            background-color: currentColor;
            z-index: 1;
        }

        .multisteps-form__progress-btn:first-child:after {
            display: none;
        }

        .multisteps-form__progress-btn.js-active {
            color: #28a745;
            ;
        }

        .multisteps-form__progress-btn.js-active:before {
            -webkit-transform: translateX(-50%) scale(1.2);
            transform: translateX(-50%) scale(1.2);
            background-color: currentColor;
        }

        .multisteps-form__form {
            position: relative;
        }

        .multisteps-form__panel {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 0;
            opacity: 0;
            visibility: hidden;
        }

        .multisteps-form__panel.js-active {
            height: auto;
            opacity: 1;
            visibility: visible;
        }

        .multisteps-form__panel[data-animation="scaleOut"] {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }

        .multisteps-form__panel[data-animation="scaleOut"].js-active {
            transition-property: all;
            transition-duration: 0.2s;
            transition-timing-function: linear;
            transition-delay: 0s;
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        .multisteps-form__panel[data-animation="slideHorz"] {
            left: 50px;
        }

        .multisteps-form__panel[data-animation="slideHorz"].js-active {
            transition-property: all;
            transition-duration: 0.25s;
            transition-timing-function: cubic-bezier(0.2, 1.13, 0.38, 1.43);
            transition-delay: 0s;
            left: 0;
        }

        .multisteps-form__panel[data-animation="slideVert"] {
            top: 30px;
        }

        .multisteps-form__panel[data-animation="slideVert"].js-active {
            transition-property: all;
            transition-duration: 0.2s;
            transition-timing-function: linear;
            transition-delay: 0s;
            top: 0;
        }

        .multisteps-form__panel[data-animation="fadeIn"].js-active {
            transition-property: all;
            transition-duration: 0.3s;
            transition-timing-function: linear;
            transition-delay: 0s;
        }

        .multisteps-form__panel[data-animation="scaleIn"] {
            -webkit-transform: scale(0.9);
            transform: scale(0.9);
        }

        .multisteps-form__panel[data-animation="scaleIn"].js-active {
            transition-property: all;
            transition-duration: 0.2s;
            transition-timing-function: linear;
            transition-delay: 0s;
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        h5.multisteps-form__title {
            font-size: 16px;
        }

        .select2-container {
            padding-right: 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            right: 6px;
        }

        .select2-container--default .select2-selection--single {
            border-color: #ddd;
        }
        .pt-5{
            padding-top: 1rem!important;
        }

    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0 text-dark">@lang('Profile Management') </h4>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('Profile Management')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title w-100">
                        @if (session()->get('language') == 'bn')
                            {{ isset($profileData) ? $profileData->nameBng : __('Parliament Member Information') }}
                        @else
                            {{ isset($profileData) ? $profileData->nameEng : __('Parliament Member Information') }}
                        @endif
                        <a href="{{ route('admin.profile-activities.v2profiles.index') }}"
                            class="btn btn-info float-right"><i class="fa fa-list mr-2"></i>
                            @lang('Parliament Member List')
                        </a>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            
                <div class="multisteps-form">
                    <div class="myloader d-none"></div>
                    <div class="content" id="profile_container">
                    </div>
                    <script>
                        $(document).ready(function() {
                            load_data('view');
                        });
                
                        function load_data(type) {
                            //$('#profile_container').html('');
                            if (type == 'view') {
                                $("#view_button").removeClass('block');
                                $("#view_button").addClass('d-none');
                                $("#edit_button").removeClass('d-none');
                                $("#edit_button").addClass('block');
                
                            }
                            if (type == 'edit') {
                                $("#view_button").removeClass('d-none');
                                $("#view_button").addClass('block');
                                $("#edit_button").removeClass('block');
                                $("#edit_button").addClass('d-none');
                
                            }
                            $('#profile_container').html('<center><img src="{{ asset('public/images/lottery.gif') }}"></center>');
                            $.ajax({
                                url: "{{ url('/profile-activities/profile_details') }}/" + type,
                                type: "GET",
                                data: {
                                    id: "{{ $profileData->profileID }}"
                                },
                                success: function(response) {
                                    $('#profile_container').html(response);
                                    //DOM elements
                        const DOMstrings = {
                            stepsBtnClass: 'multisteps-form__progress-btn',
                            stepsBtns: document.querySelectorAll(`.multisteps-form__progress-btn`),
                            stepsBar: document.querySelector('.multisteps-form__progress'),
                            stepsForm: document.querySelector('.multisteps-form__form'),
                            stepsFormTextareas: document.querySelectorAll('.multisteps-form__textarea'),
                            stepFormPanelClass: 'multisteps-form__panel',
                            stepFormPanels: document.querySelectorAll('.multisteps-form__panel'),
                            stepPrevBtnClass: 'js-btn-prev',
                            stepNextBtnClass: 'js-btn-next'
                        };
                
                
                        //remove class from a set of items
                        const removeClasses = (elemSet, className) => {
                
                            elemSet.forEach(elem => {
                
                                elem.classList.remove(className);
                
                            });
                
                        };
                
                        //return exect parent node of the element
                        const findParent = (elem, parentClass) => {
                
                            let currentNode = elem;
                
                            while (!currentNode.classList.contains(parentClass)) {
                                currentNode = currentNode.parentNode;
                            }
                
                            return currentNode;
                
                        };
                
                        //get active button step number
                        const getActiveStep = elem => {
                            return Array.from(DOMstrings.stepsBtns).indexOf(elem);
                        };
                
                        //set all steps before clicked (and clicked too) to active
                        const setActiveStep = activeStepNum => {
                
                            //remove active state from all the state
                            removeClasses(DOMstrings.stepsBtns, 'js-active');
                
                            //set picked items to active
                            DOMstrings.stepsBtns.forEach((elem, index) => {
                
                                if (index <= activeStepNum) {
                                    elem.classList.add('js-active');
                                }
                
                            });
                        };
                
                        //get active panel
                        const getActivePanel = () => {
                
                            let activePanel;
                
                            DOMstrings.stepFormPanels.forEach(elem => {
                
                                if (elem.classList.contains('js-active')) {
                
                                    activePanel = elem;
                
                                }
                
                            });
                
                            return activePanel;
                
                        };
                
                        //open active panel (and close unactive panels)
                        const setActivePanel = activePanelNum => {
                
                            //remove active class from all the panels
                            removeClasses(DOMstrings.stepFormPanels, 'js-active');
                
                            //show active panel
                            DOMstrings.stepFormPanels.forEach((elem, index) => {
                                if (index === activePanelNum) {
                
                                    elem.classList.add('js-active');
                
                                    setFormHeight(elem);
                
                                }
                            });
                
                        };
                
                        //set form height equal to current panel height
                        const formHeight = activePanel => {
                
                            const activePanelHeight = activePanel.offsetHeight;
                
                            DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;
                
                        };
                
                        const setFormHeight = () => {
                            const activePanel = getActivePanel();
                
                            formHeight(activePanel);
                        };
                
                        //STEPS BAR CLICK FUNCTION
                        DOMstrings.stepsBar.addEventListener('click', e => {
                
                            //check if click target is a step button
                            const eventTarget = e.target;
                
                            if (!eventTarget.classList.contains(`${DOMstrings.stepsBtnClass}`)) {
                                return;
                            }
                
                            //get active button step number
                            const activeStep = getActiveStep(eventTarget);
                
                            //set all steps before clicked (and clicked too) to active
                            setActiveStep(activeStep);
                
                            //open active panel
                            setActivePanel(activeStep);
                        });
                
                        //PREV/NEXT BTNS CLICK
                        DOMstrings.stepsForm.addEventListener('click', e => {
                
                            const eventTarget = e.target;
                
                            //check if we clicked on `PREV` or NEXT` buttons
                        if (!(eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`) || eventTarget.classList
                                .contains(`${DOMstrings.stepNextBtnClass}`))) {
                            return;
                        }
                
                        //find active panel
                        const activePanel = findParent(eventTarget, `${DOMstrings.stepFormPanelClass}`);
                
                        let activePanelNum = Array.from(DOMstrings.stepFormPanels).indexOf(activePanel);
                
                        //set active step and active panel onclick
                        if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
                                activePanelNum--;
                
                            } else {
                
                                activePanelNum++;
                
                            }
                
                            setActiveStep(activePanelNum);
                            setActivePanel(activePanelNum);
                
                        });
                
                        //SETTING PROPER FORM HEIGHT ONLOAD
                        window.addEventListener('load', setFormHeight, false);
                
                        //SETTING PROPER FORM HEIGHT ONRESIZE
                        window.addEventListener('resize', setFormHeight, false);
                
                        //changing animation via animation select !!!YOU DON'T NEED THIS CODE (if you want to change animation type, just change form panels data-attr)
                
                        const setAnimationType = newType => {
                            DOMstrings.stepFormPanels.forEach(elem => {
                                elem.dataset.animation = newType;
                            });
                        };
                
                        $(".select2").select2({});
                                },
                                error: function(res) {
                                    $('#profile_container').html('@lang("No Data Found")');
                                }
                            });
                
                        }
                
                        function load_report(type, id) {
                            console.log(type, id);
                            if (type == 'pdf') {
                                my_loader('start');
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                    }
                                });
                                $.ajax({
                                    type: "POST",
                                    crossDomain: true,
                                    data: JSON.stringify({
                                        doctype: type,
                                        profile_id: id
                                    }),
                                    url: "{{ url('/profile-activities/profiledoc') }}",
                                    contentType: "application/json",
                                    success: function(data) {
                                        const linkSource = data;
                                        const downloadLink = document.createElement("a");
                                        const fileName = "profile_" + id + ".pdf";
                                        downloadLink.href = linkSource;
                                        //window.location.href = downloadLink;
                                        downloadLink.download = fileName;
                                        downloadLink.click();
                                        my_loader('stop');
                                    },
                                    error: function(res) {
                                        my_loader('stop');
                                    }
                                });
                            } else {
                
                            }
                
                        }
                        
                    </script>
                </div>
                <div class="celarfix"></div>
            
        </div>
        <div class="celarfix"></div>
    </div>
@endsection

@section('script')
    <script>
        //DOM elements
        const DOMstrings = {
            stepsBtnClass: 'multisteps-form__progress-btn',
            stepsBtns: document.querySelectorAll(`.multisteps-form__progress-btn`),
            stepsBar: document.querySelector('.multisteps-form__progress'),
            stepsForm: document.querySelector('.multisteps-form__form'),
            stepsFormTextareas: document.querySelectorAll('.multisteps-form__textarea'),
            stepFormPanelClass: 'multisteps-form__panel',
            stepFormPanels: document.querySelectorAll('.multisteps-form__panel'),
            stepPrevBtnClass: 'js-btn-prev',
            stepNextBtnClass: 'js-btn-next'
        };


        //remove class from a set of items
        const removeClasses = (elemSet, className) => {

            elemSet.forEach(elem => {

                elem.classList.remove(className);

            });

        };

        //return exect parent node of the element
        const findParent = (elem, parentClass) => {

            let currentNode = elem;

            while (!currentNode.classList.contains(parentClass)) {
                currentNode = currentNode.parentNode;
            }

            return currentNode;

        };

        //get active button step number
        const getActiveStep = elem => {
            return Array.from(DOMstrings.stepsBtns).indexOf(elem);
        };

        //set all steps before clicked (and clicked too) to active
        const setActiveStep = activeStepNum => {

            //remove active state from all the state
            removeClasses(DOMstrings.stepsBtns, 'js-active');

            //set picked items to active
            DOMstrings.stepsBtns.forEach((elem, index) => {

                if (index <= activeStepNum) {
                    elem.classList.add('js-active');
                }

            });
        };

        //get active panel
        const getActivePanel = () => {

            let activePanel;

            DOMstrings.stepFormPanels.forEach(elem => {

                if (elem.classList.contains('js-active')) {

                    activePanel = elem;

                }

            });

            return activePanel;

        };

        //open active panel (and close unactive panels)
        const setActivePanel = activePanelNum => {

            //remove active class from all the panels
            removeClasses(DOMstrings.stepFormPanels, 'js-active');

            //show active panel
            DOMstrings.stepFormPanels.forEach((elem, index) => {
                if (index === activePanelNum) {

                    elem.classList.add('js-active');

                    setFormHeight(elem);

                }
            });

        };

        //set form height equal to current panel height
        const formHeight = activePanel => {

            const activePanelHeight = activePanel.offsetHeight;

            DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;

        };

        const setFormHeight = () => {
            const activePanel = getActivePanel();

            formHeight(activePanel);
        };

        //STEPS BAR CLICK FUNCTION
        DOMstrings.stepsBar.addEventListener('click', e => {

            //check if click target is a step button
            const eventTarget = e.target;

            if (!eventTarget.classList.contains(`${DOMstrings.stepsBtnClass}`)) {
                return;
            }

            //get active button step number
            const activeStep = getActiveStep(eventTarget);

            //set all steps before clicked (and clicked too) to active
            setActiveStep(activeStep);

            //open active panel
            setActivePanel(activeStep);
        });

        //PREV/NEXT BTNS CLICK
        DOMstrings.stepsForm.addEventListener('click', e => {

            const eventTarget = e.target;

            //check if we clicked on `PREV` or NEXT` buttons
        if (!(eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`) || eventTarget.classList
                .contains(`${DOMstrings.stepNextBtnClass}`))) {
            return;
        }

        //find active panel
        const activePanel = findParent(eventTarget, `${DOMstrings.stepFormPanelClass}`);

        let activePanelNum = Array.from(DOMstrings.stepFormPanels).indexOf(activePanel);

        //set active step and active panel onclick
        if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
                activePanelNum--;

            } else {

                activePanelNum++;

            }

            setActiveStep(activePanelNum);
            setActivePanel(activePanelNum);

        });

        //SETTING PROPER FORM HEIGHT ONLOAD
        window.addEventListener('load', setFormHeight, false);

        //SETTING PROPER FORM HEIGHT ONRESIZE
        window.addEventListener('resize', setFormHeight, false);

        //changing animation via animation select !!!YOU DON'T NEED THIS CODE (if you want to change animation type, just change form panels data-attr)

        const setAnimationType = newType => {
            DOMstrings.stepFormPanels.forEach(elem => {
                elem.dataset.animation = newType;
            });
        };

        //selector onchange - changing animation
        const animationSelect = document.querySelector('.pick-animation__select');

        animationSelect.addEventListener('change', () => {
            const newAnimationType = animationSelect.value;

            setAnimationType(newAnimationType);
        });
    </script>

@endsection
