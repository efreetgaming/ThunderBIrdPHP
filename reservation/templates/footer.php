<footer
          class="text-center text-lg-start text-white"
          style="background-color: #800000"
          >
    <!-- Grid container -->
    <div class="container p-4 pb-0">
      <!-- Section: Links -->
      <section class="">
        <!--Grid row-->
        <div class="row">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">
             Thunder Bird Resorts & Casinos
            </h6>
            <p>
                    Eastridge Avenue
                    Binangonan, Rizal
                    Philippines 1940
            </p>
          </div>
          <!-- Grid column -->

          <hr class="w-100 clearfix d-md-none" />

          <!-- Grid column -->
   <!--        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">=</h6>
            <p>
              <a class="text-white">MDBootstrap</a>
            </p>
            <p>
              <a class="text-white">MDWordPress</a>
            </p>
            <p>
              <a class="text-white">BrandFlow</a>
            </p>
            <p>
              <a class="text-white">Bootstrap Angular</a>
            </p>
          </div> -->
          <!-- Grid column -->

          <hr class="w-100 clearfix d-md-none" />

          <!-- Grid column -->
          <hr class="w-100 clearfix d-md-none" />

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">Contact</h6>
            <p><i class="fas fa-home mr-3"></i> Thunderbird Resort Rizal</p>
            <p><i class="fas fa-envelope mr-3"></i> sales@thunderbird-asia.com</p>
            <p><i class="fas fa-phone mr-3"></i> + 8651-6888</p>
            <p><i class="fas fa-print mr-3"></i> + 8651-6888</p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold">Follow us</h6>

            <!-- Facebook -->
            <a
               class="btn btn-primary btn-floating m-1"
               style="background-color: #3b5998"
               href="https://web.facebook.com/ThunderbirdResortsandCasinosRizal/?_rdc=1&_rdr"
               role="button"
               ><i class="fab fa-facebook-f"></i
              ></a>

            <!-- Twitter -->
            <a
               class="btn btn-primary btn-floating m-1"
               style="background-color: #55acee"
               href="https://twitter.com/ThunderbirdPH"
               role="button"
               ><i class="fab fa-twitter"></i
              ></a>

            <!-- Google -->
            <!-- <a
               class="btn btn-primary btn-floating m-1"
               style="background-color: #dd4b39"
               href="#!"
               role="button"
               ><i class="fab fa-google"></i
              ></a> -->

            <!-- Instagram -->
            <a
               class="btn btn-primary btn-floating m-1"
               style="background-color: #ac2bac"
               href="https://www.instagram.com/thunderbirdrizal/"
               role="button"
               ><i class="fab fa-instagram"></i
              ></a>

            <!-- Linkedin -->
            <!-- <a
               class="btn btn-primary btn-floating m-1"
               style="background-color: #0082ca"
               href="#!"
               role="button"
               ><i class="fab fa-linkedin-in"></i
              ></a> -->
            <!-- Github -->
            <!-- <a
               class="btn btn-primary btn-floating m-1"
               style="background-color: #333333"
               href="#!"
               role="button"
               ><i class="fab fa-github"></i
              ></a>
          </div>
        </div> -->
        <!--Grid row-->
      </section>
      <!-- Section: Links -->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div
         class="text-center p-3"
         style="background-color: rgba(0, 0, 0, 0.2)"
         >
     Copyright © Mga Bumabatak 2024
      
    <!-- Copyright -->
  </footer>
  <!-- Footer -->
<!-- End of .container -->
</body>
<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', () => {
    // Conuntries
    const countries = document.querySelector("#country");

    fetch(`https://restcountries.com/v2/all`).then(res => {
        return res.json();
    }).then(data => {
        let output = ""
        data.forEach(country => {
            // console.log(country.name)
            if (country.name === "Philippines") {
                output += `<option value="${country.name}" selected>${country.name}</option>`
            } else {
                output += `<option value="${country.name}">${country.name}</option>`
            }
        });
        countries.innerHTML = output

    }).catch(err => {
        console.log(err)
    })


    // Span Tag for Available Rooms
    document.getElementById('room_type').addEventListener('change', function(event) {
        // Get the selected room category
        const selectedRoomType = event.target.value;

        // Fetch the available rooms for the selected room category
        fetchAvailableRooms(selectedRoomType);
    });

    function fetchAvailableRooms(roomType) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'fetch_available_rooms.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Parse the JSON response
                const response = JSON.parse(xhr.responseText);

                // Update the span tag with the available rooms for the selected room category
                document.getElementById('available_rooms').textContent = response.available_rooms;
            }
        };
        xhr.send('room_type=' + encodeURIComponent(roomType));
}
});
</script>
<script src="https://kit.fontawesome.com/fd802afef5.js" crossorigin="anonymous"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', () => {
    // Conuntries
    const countries = document.querySelector("#country");

    fetch(`https://restcountries.com/v2/all`).then(res => {
        return res.json();
    }).then(data => {
        let output = ""
        data.forEach(country => {
            // console.log(country.name)
            if (country.name === "Philippines") {
                output += `<option value="${country.name}" selected>${country.name}</option>`
            } else {
                output += `<option value="${country.name}">${country.name}</option>`
            }
        });
        countries.innerHTML = output

    }).catch(err => {
        console.log(err)
    })


    // Span Tag for Available Rooms
    document.getElementById('room_type').addEventListener('change', function(event) {
        // Get the selected room category
        const selectedRoomType = event.target.value;

        // Fetch the available rooms for the selected room category
        fetchAvailableRooms(selectedRoomType);
    });

    function fetchAvailableRooms(roomType) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'fetch_available_rooms.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Parse the JSON response
                const response = JSON.parse(xhr.responseText);

                // Update the span tag with the available rooms for the selected room category
                document.getElementById('available_rooms').textContent = response.available_rooms;
            }
        };
        xhr.send('room_type=' + encodeURIComponent(roomType));
}
});
</script>
<script src="https://kit.fontawesome.com/fd802afef5.js" crossorigin="anonymous"></script>
<script src="/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/js/jquery.js"></script>