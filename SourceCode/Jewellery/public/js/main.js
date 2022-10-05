function handleProductDetail() {
  $('.btn-productDetail').on('click', function (e) {
    e.preventDefault();
    let id = $(this).attr('data-id');
    $('#modalDetail').modal('show');
    console.log(id);
    $.ajax({
      url: 'getDetailById.php?productId=' + id,
      type: 'get',
      contentType: false,
      processData: false,
      success: function (res) {
        $('#productDetail').html(res);
        //navactive responsive
        $(".product_navactive").owlCarousel({
          autoplay: false,
          loop: true,
          nav: true,
          items: 4,
          dots: false,
          navText: [
            '<i class="ion-chevron-left arrow-left"></i>',
            '<i class="ion-chevron-right arrow-right"></i>',
          ],
          responsiveClass: true,
          responsive : {
            0: {
              items : 1
            }, 

            250: {
              items : 2
            },

            600: {
              items : 3
            },

            1000: {
              items : 4
            },
          },
        });

        $(".modal").on("shown.bs.modal", function (e) {
          $(".product_navactive").resize();
        });

        $(".product_navactive a").on("click", function (e) {
          e.preventDefault();
          var $href = $(this).attr("href");
          $(".product_navactive a").removeClass("active");
          $(this).addClass("active");
          $(".product-details-large .tab-pane").removeClass("active show");
          $(".product-details-large " + $href).addClass("active show");
        });
      },
      error: function (err) {
        console.log(err);
      }
    });
  });
}
$(document).ready(function () {
  // Ticker
  // Create two 2 variable with the names of the months and the days in an array
  let dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
  let monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
  // Create a newDate() object
  var newDate = new Date();
  // Extract the current date from Date object
  newDate.setDate(newDate.getDate());
  // Output the day, date, month and year   
  $('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

  setInterval(function () {
    // Create a newDate() object and extract the hours of the current time on the visitor's
    var hours = new Date().getHours();
    // Add a leading zero to the hours value
    $("#hours").html((hours < 10 ? "0" : "") + hours);
    // Create a newDate() object and extract the minutes of the current time on the visitor's
    var minutes = new Date().getMinutes();
    // Add a leading zero to the minutes value
    $("#min").html((minutes < 10 ? "0" : "") + minutes);
    // Create a newDate() object and extract the seconds of the current time on the visitor's
    var seconds = new Date().getSeconds();
    // Add a leading zero to seconds value
    $("#sec").html((seconds < 10 ? "0" : "") + seconds);
  }, 1000);

  handleProductDetail();
  //navbar cart
  $(".cart_link > a").on("click", function () {
    $(".mini_cart").addClass("active");
  });

  $(".mini_cart_close > a").on("click", function () {
    $(".mini_cart").removeClass("active");
  });

  //sticky navbar
  $(window).on("scroll", function () {
    var scroll = $(window).scrollTop();
    if (scroll < 250) {
      $(".sticky-header").removeClass("sticky");
    } else {
      $(".sticky-header").addClass("sticky");
    }
  });

  // background image
  function dataBackgroundImage() {
    $("[data-bgimg]").each(function () {
      var bgImgUrl = $(this).data("bgimg");
      $(this).css({
        "background-image": "url(" + bgImgUrl + ")", // concatenation
      });
    });
  }

  $(window).on("load", function () {
    dataBackgroundImage();
  });

  //for carousel slider of the slider section
  $(".slider_area").owlCarousel({
    animateOut: "fadeOut",
    autoplay: true,
    loop: true,
    nav: false,
    autoplayTimeout: 6000,
    items: 1,
    dots: true,
  });

  //for tooltip
  $('[data-toggle="tooltip"]').tooltip();

  //tooltip active
  $(".action_links ul li a, .quick_button a").tooltip({
    animated: "fade",
    placement: "top",
    container: "body",
  });

  //product row activation responsive
  $(".product_row1").slick({
    centerMode: true,
    centerPadding: "0",
    slidesToShow: 5,
    arrows: true,
    // autoplay: true,
    // autoplaySpeed: 2000,
    prevArrow: '<button class="prev_arrow"><i class="ion-chevron-left"></i></button>',
    nextArrow: '<button class="next_arrow"><i class="ion-chevron-right"></i></button>',
    responsive: [{
      breakpoint: 1025,
      settings: {
        slidesToShow: 4,
      },
    },

    {
      breakpoint: 992,
      settings: {
        slidesToShow: 3,
      },
    },

    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
      },
    },

    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        arrows: false,
      },
    },
    ],
  });
  $('.btn-delete').on('click', function (e) {
    e.preventDefault();
    let id_productCart = $(this).attr('id_productCart');
    let name_productCart = $(this).attr('name_productCart');
    Swal.fire({
      title: `Are you sure you want to delete product ${name_productCart} ?`,
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = `?action=delete&productId=${id_productCart}`;
      } else {
        Swal.fire(
          'Not Delete!',
          'Product has not been deleted yet.',
          'error'
        )
      }
    })
  });
  // Page_view count
  let counterContainer = $('#website-counter');
  let visitCount = localStorage.getItem('page_view');
  
  // Check if page_view entry is present
  if(visitCount) {
    visitCount = Number(visitCount) + 1;
    localStorage.setItem('page_view', visitCount);
  } else {
    visitCount = 1;
    localStorage.setItem('page_view', 1);
  }

  counterContainer.html(counterContainer);
  $('#website-counter').html((visitCount < 10 ? "0" : "") + visitCount);
});

