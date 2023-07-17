@extends('backend.layouts.app')

@section('content')
{{-- <script src='{{ asset('public/localize/local_bn.js') }}' type='text/javascript'></script>
<script src='{{ asset('public/localize/local_en.js') }}' type='text/javascript'></script>
<script src='{{ asset('public/localize/jquery_bangla_date_picker.js') }}' type='text/javascript'></script>
<link rel='stylesheet' href="{{ asset('public/localize/jquery-ui.css') }}"/> --}}
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

                        &nbsp;
                        <button type="button" class="btn btn-warning float-right" onClick="load_report('pdf','{{$profileID}}')" style="margin-left:15px;"><i class="fas fa-file-pdf"></i> @lang("PDF")</button>&nbsp;

                        <a href="javascript:(void);" id="edit_button" class="btn btn-info float-right d-none"
                            onclick="load_data('edit')"><i class="fa fa-edit mr-2"></i>
                            @lang('Edit')
                        </a> &nbsp;

                        <a href="javascript:(void);" id="view_button" class="btn btn-info float-right d-none"
                            onclick="load_data('view')"><i class="fa fa-eye mr-2"></i>
                            @lang('View')
                        </a> &nbsp;
                    </h4>
                </div>
            </div>
        </div>
    </div>
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
                    id: "{{ $profileID }}"
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
@endsection
