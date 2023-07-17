      <style>
          @media (max-width: 768px) {
              .carousel-inner .carousel-item>div {
                  display: none;
              }

              .carousel-inner .carousel-item>div:first-child {
                  display: block;
              }
          }

          .carousel-inner .carousel-item.active,
          .carousel-inner .carousel-item-next,
          .carousel-inner .carousel-item-prev {
              display: flex;
          }

          /* display 3 */
          @media (min-width: 768px) {

              .carousel-inner .carousel-item-right.active,
              .carousel-inner .carousel-item-next {
                  transform: translateX(33.333%);
              }

              .carousel-inner .carousel-item-left.active,
              .carousel-inner .carousel-item-prev {
                  transform: translateX(-33.333%);
              }
          }

          .carousel-inner .carousel-item-right,
          .carousel-inner .carousel-item-left {
              transform: translateX(0);
          }
          .carousel-control-next {
                background: transparent;
            }
          .carousel-control-prev {
                background: transparent;
            }
      </style>
      <div class="row mx-auto my-auto">
          <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
              <div class="carousel-inner w-100" role="listbox">
                  @if(count($question_list)>0)
                    @php $x=0; @endphp
                    @foreach($question_list as $q)
                    @php
                        if($x==0){
                                $active_tag = 'active';
                            }
                            else{
                                $active_tag = '';
                            }
                    @endphp
                  <div class="carousel-item {{$active_tag}}">
                      <div class="col-12">
                          <div class="card card-body" style="min-height: 212px;">
                            <div id="question_loader_form_{{$q->q_id}}" class="d-none">
                                <center><img src="{{asset("public/images/lottery.gif")}}"></center>
                            </div>
                            <div id="question_content_form_{{$q->q_id}}">
                                <form id="form_{{$q->q_id}}" method="POST" enctype="multipart/form-data" action="javascript:void(0)" class="vote_form">
                                <h4>{{$q->question_name}}</h4>
                                @if($q->questions->ans_type==1)
                                @php $i=0 @endphp
                                
                                    @foreach($q->questions->options as $a)
                                    
                                        <div class="form-check"> <input class="form-check-input" type="radio" name="pole_question" data-id="{{$q->q_id}}_{{$a->id}}" id="questionID_{{$q->q_id}}_{{$a->id}}" /> <label class="form-check-label" for="questionID_{{$q->q_id}}_{{$a->id}}"> {{$a->title}} </label></div>
                                    
                                    @endforeach
                                <p style="text-align: center;">
                                    <button type="submit" class="btn btn-info vote_for">@lang('Vote For')</button>
                                </p>
                                @endif
                                </form>
                            </div>
                          </div>
                      </div>
                  </div>
                  @php $x++ @endphp
                  @endforeach
                  @endif
              </div>
              <a class="carousel-control-prev w-auto" href="#recipeCarousel" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next w-auto" href="#recipeCarousel" role="button" data-slide="next">
                  <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
              </a>
          </div>
      </div>

      <script>
          $(function() {
              $('#recipeCarousel').carousel({
                  interval: false,
                  
              })

              /* $('.carousel .carousel-item').each(function() {
                  var minPerSlide = 3;
                  var next = $(this).next();
                  if (!next.length) {
                      next = $(this).siblings(':first');
                  }
                  next.children(':first-child').clone().appendTo($(this));

                  for (var i = 0; i < minPerSlide; i++) {
                      next = next.next();
                      if (!next.length) {
                          next = $(this).siblings(':first');
                      }

                      next.children(':first-child').clone().appendTo($(this));
                  }
              }); */
              $('.carousel .item').each(function(){
                var next = $(this).next();
                if (!next.length) {
                    next = $(this).siblings(':first');
                }
                next.children(':first-child').clone().appendTo($(this));

                for (var i=0;i<2;i++) {
                    next=next.next();
                    if (!next.length) {
                    next = $(this).siblings(':first');
                    }

                    next.children(':first-child').clone().appendTo($(this));
                }
                });
          });

          $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });

            $("form.vote_form").each(function () {
                var $this = $(this);
                var $parent = $this.parent();
                let form = $(this)[0];
                let formData = new FormData();
                
                $this.submit(function () {
                    $("div.form-check input[type=radio]:checked").each( function() {
                            formData.append('answer', $(this).data('id'));
                    });
                    console.log('question id: '+$this.attr('id'));
                    $('#question_loader_'+$this.attr('id')).removeClass('d-none');
                    $('#question_loader_'+$this.attr('id')).addClass('show');
                    $('#question_content_'+$this.attr('id')).removeClass('show');
                    $('#question_content_'+$this.attr('id')).addClass('d-none');
                    formData.append('pole_id', "{{$pole_id}}");
                    $.ajax({
                        type: 'POST',
                        url : "{{ url('/savepole') }}",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            data = JSON.parse(data);
                            //console.log(data.message);
                            if (data.status==true) {
                                $('#question_loader_'+$this.attr('id')).removeClass('show');
                                $('#question_loader_'+$this.attr('id')).addClass('d-none');
                                $('#question_content_'+$this.attr('id')).removeClass('d-none');
                                $('#question_content_'+$this.attr('id')).addClass('show');
                                Swal.fire({
                                    text: '@lang("Data Saved successfully")',
                                    type: 'success'
                                });
                            } else {
                                Swal.fire({
                                    text: '@lang("You have already voted")',
                                    type: 'warning'
                                });
                                $('#question_loader_'+$this.attr('id')).removeClass('show');
                                $('#question_loader_'+$this.attr('id')).addClass('d-none');
                                $('#question_content_'+$this.attr('id')).removeClass('d-none');
                                $('#question_content_'+$this.attr('id')).addClass('show');
                            }
                        },
                        error: function(data) {
                            $('#question_loader_'+$this.attr('id')).removeClass('show');
                            $('#question_loader_'+$this.attr('id')).addClass('d-none');
                            $('#question_content_'+$this.attr('id')).removeClass('d-none');
                            $('#question_content_'+$this.attr('id')).addClass('show');
                        }
                    });
                });
            });
        });
      </script>