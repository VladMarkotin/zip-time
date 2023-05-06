{{-- <div class="container d-flex justify-content-center feedback" >
  <div class="card mt-5 pb-5" style="border-radius: 15px">
    <div class="d-flex flex-row justify-content-between p-3 adiv text-white">
      <i class="fas fa-chevron-left"></i>
      <span class="pb-3">feedback</span>
      <i class="fas fa-times"></i>
    </div>
 <div class="mt-2 p-4 text-center">
      <h6 class="mb-0">Your feedback help us to improve.</h6>
      <small class="px-3">Please let us know about your chat experience.</small>
      <div class="d-flex flex-row justify-content-center mt-2">
        <img src="https://img.icons8.com/emoji/48/000000/angry-face-emoji--v2.png"/>
        <img src="https://img.icons8.com/fluent/48/000000/sad.png"/>
        <img src="https://img.icons8.com/color/48/000000/happy.png"/>
        <img src="https://img.icons8.com/emoji/48/000000/smiling-face.png"/>
        <img src="https://img.icons8.com/color/48/000000/lol.png"/>
      </div>
      <div class="form-group mt-4">
        <textarea class="form-control" rows="4" placeholder="Message"></textarea>
      </div>
      <div class="mt-2">
        <button type="button" class="btn btn-primary btn-block"><span>Send feedback</span></button>
      </div>
      <p class="mt-3">Continue without sending feedback</p>
    </div> 

    <div class="mt-2 p-4 text-center mt-5">
      <div class="mt-2">
          <button type="button" class="btn btn-primary btn-block p-3 fw-bold "><span >Report an issue</span> </button>
        </div>
        <div class="mt-2">
          <button type="button" class="btn btn-primary btn-block p-3 fw-bold  mt-3"><span>Request a feature</span></button>
        </div>
      
      <div class="mt-2">
        <button type="button" class="btn btn-primary btn-block p-3 fw-bold mt-3"><span>Contact us</span></button>
      </div>
      <p class="mt-3">Continue without sending feedback</p>
    </div>


  </div>
</div> --}}


<div class="card content-container">

  <div class="feedback-main">
<div class="d-flex justify-content-between p-4 text-white ">
     <span ><h3 class="fw-bold zoom">Quipl</h3></span>
      <span style="font-size: 20px" role="button"  id="feedback-close" class="zoom"><i class="fa fa-times"></i></span>
    </div> 


    <div class="card-header mt-4">
      <h2 class="fw-bold mx-4"><span class="text-secondary"> Hi </span><img src="{{ asset('images/wave.png') }}" alt="" width="35px"><br>
   <span class="text-white">How can we help?</span> </h2>

    </div>

    <div class="card-body p-4 mt-2 mb-0">
  
        <div class="d-flex flex-column ">
          <div class="feedback-select" role="button" id="feedback-report"> <p> <span class="fw-bold">Report an issue</span><br><span class="text-secondary" >Found a bug? Let us know.</span> <span class="float-end mx-3" style="font-size: 20px; color:#d42929"><i class="fa fa-bug" aria-hidden="true"></i></span> </p></div>
          <div class="feedback-select"  role="button" id="feedback-request"> <p> <span class="fw-bold">Request a feature</span><br><span class="text-secondary" >What would you like to see next?</span><span class="float-end  mx-3" style="font-size: 23px; color:rgb(190, 190, 67)"><i class="fa fa-lightbulb-o" aria-hidden="true"></i></span></p></div>
          <div class="feedback-select"  role="button" id="feedback-contact"> <p> <span class="fw-bold">Contact us</span><br><span class="text-secondary" >We are here to help.</span><span class="float-end mx-3" style="font-size: 20px; color:rgb(80, 21, 134)"><i class="fa fa-envelope" aria-hidden="true"></i></span></p></div></div>
        </div> 
     
        
    

  </div>




  <div class="feedback-content">
   

                      {{-- REPORT BUG --}}



        <div class="card feedback-bug" style="border-radius:17px;">
          <div class="d-flex flex-row justify-content-between p-3 adiv text-white">

          <span   id="feedback-back" role="button" class="zoom"> <i class="fa fa-chevron-left"></i></span> 
          <span class="fw-bold">Report an issue</span>
          <span  id="feedback-close" role="button" class="zoom"> <i class="fa fa-times"></i></span> 
          </div>

          <div class="mt-2 p-4 ">
            <h6 class="mb-0 ">Found a bug? Let us know.</h6>
          
        <label for="message" class="fw-bold mt-3">Describe the issue<span class="text-danger">*</span></label>
            <div class="form-group ">
              <textarea class="form-control " placeholder="The more information, the better" name="message"></textarea>
            </div>
            <label for="message" class="fw-bold mt-2">Email<span class="text-danger">*</span></label>
            <div class="form-group mt-1">
              <input class="form-control" type="email" placeholder="Email" name="email">
            </div>
            <div class="media flex-row justify-content-between mt-4">
              <button type="button" class="btn btn-outline-secondary btn-sm mx-3"><i class="fa fa-camera" aria-hidden="true"></i> Mark the bug</button>
              <button type="button" class="btn btn-outline-secondary btn-sm mx-3"><i class="fa fa-video-camera" aria-hidden="true"></i> Record screen</button>
            </div>
            <div class="mt-5">
              <button type="button" class="btn btn- btn-block text-white " style="background: #a10000; border-radius:8px"><span>Send feedback</span></button>
            </div>
           
          </div> 
          <div class="p-2">
            <p class=" text-center text-secondary fw-bold  fst-italic">Your feedback will help us improve.</p>
         </div>
        </div>



                                     {{-- REQUEST FEATURE --}}


        <div class="card feedback-request" style="border-radius:17px; ">
          <div class="d-flex flex-row justify-content-between p-4 adiv text-white">

            <span   id="feedback-back" role="button" class="zoom"> <i class="fa fa-chevron-left"></i></span> 
            <span class="fw-bold">Request a feature</span>
            <span  id="feedback-close" role="button" class="zoom"> <i class="fa fa-times"></i></span> 
            </div>

          <div class="mt-2 p-4 ">
            <h6 class="mb-0 ">Let us know what you would like to see next.</h6>
          
        <label for="message" class="fw-bold mt-3">subject <span class="text-danger">*</span></label>
            <div class="form-group ">
           
              <input class="form-control" type="text" placeholder="The more details, the better." name="subject">
            </div>




            <label for="message" class="fw-bold mt-2">Description<span class="text-danger">*</span></label>
            
            <div class="form-group mt-1">
                <textarea class="form-control " placeholder="What feature would you like top see next?" name="description"></textarea>
            </div>

            <label for="email" class="fw-bold mt-2">Email<span class="text-danger">*</span></label>
            <div class="form-group mt-1">
              <input class="form-control" type="email" placeholder="Email" name="email">
            </div>
         
            <div class="mt-2">
              <button type="button" class="btn btn- btn-block text-white " style="background: #a10000; border-radius:8px"><span>Send feedback</span></button>
            </div>
           
          </div> 
          <div class="">
            <p class=" text-center text-secondary fw-bold  fst-italic">Your feedback will help us improve.</p>
         </div>
        </div>

                              {{-- CONTACT US --}}


                              <div class="card feedback-contact" style="border-radius:17px; ">
                                <div class="d-flex flex-row justify-content-between p-4 adiv text-white">

                                  <span   id="feedback-back" role="button" class="zoom"> <i class="fa fa-chevron-left"></i></span> 
                                  <span class="fw-bold">Contact us</span>
                                  <span  id="feedback-close" role="button" class="zoom"> <i class="fa fa-times"></i></span> 
                                  </div>
                      
                                <div class="mt-2 p-4 ">
                                  <h6 class="mb-0 ">We are happy to answer any of your questions.</h6>
                                
                              <label for="message" class="fw-bold mt-3">Message <span class="text-danger">*</span></label>
                                  <div class="form-group ">
                                 
                                    <textarea class="form-control " rows="4"  placeholder="Your message" name="contact"></textarea>
                                  </div>
                      
         
                                  <label for="message" class="fw-bold mt-2">Email<span class="text-danger">*</span></label>
                                  
                                  <div class="form-group mt-1">
                                    <input class="form-control" type="email" placeholder="Email" name="email">
                                  </div>
                      
                                
                               
                                  <div class="mt-5">
                                    <button type="button" class="btn btn- btn-block text-white " style="background: #a10000; border-radius:8px"><span>Send feedback</span></button>
                                  </div>
                                 
                                </div> 
                                <div class="p-2">
                                  <p class=" text-center text-secondary fw-bold  fst-italic">Your feedback will help us improve.</p>
                               </div>
                              </div>
                      












                            </div>
        
       
      </div>



