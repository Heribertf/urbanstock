<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["user_type"] !== 2) {
  header("location: ./login.php");
  exit;
}
include_once './includes/header.php';
?>
<main>
  <article>
    <section class="section plans" data-section>
      <div class="container">
        <div class="about-section-el">
          <img src="assets/images/el-2.png" alt="" />
        </div>
        <h2 class="h2 section-title">Our Machine Plans</h2>

        <p class="section-text">
          Stacks is a production-ready library of stackable content blocks
          built in React Native.
        </p>

        <div class="plans-list">
          <div class="cards__card card">
            <figure class="blog-banner img-holder">
              <img src="./assets/images/m1.jpeg" width="400" height="290" loading="lazy" alt="Step 1"
                class="img-cover" />
            </figure>
            <div class="card__content">
              <h2 class="card__heading" id="v-series">V-series (V1)</h2>
              <p class="card__price">Minimum Ksh 12,500</p>
              <input type="hidden" id="v1" name="v1" readonly required value="12500">
              <input type="hidden" id="v1-id" name="v1-id" readonly required value="1">
              <ul role="list" class="card__bullets flow">
                <li>Top 10 US Stocks</li>
                <li>Return on investment 200%</li>
                <li>24/7 Priority support</li>
              </ul>
              <a href="#basic" class="card__cta cta" id="machine-one" data-open-modal-machine="choose-machine">Invest
                Now</a>
            </div>
          </div>

          <div class="cards__card card">
            <figure class="blog-banner img-holder">
              <img src="./assets/images/m4.jpeg" width="400" height="290" loading="lazy" alt="Step 1"
                class="img-cover" />
            </figure>
            <div class="card__content">
              <h2 class="card__heading" id="m-series">M-series (M1)</h2>
              <p class="card__price">Minimum Ksh 8,000</p>
              <input type="hidden" id="m1" name="m1" readonly required value="8000">
              <input type="hidden" id="m1-id" name="m1-id" readonly required value="2">
              <ul role="list" class="card__bullets flow">
                <li>Top 10 US Stocks</li>
                <li>Return on investment 200%</li>
                <li>24/7 Priority support</li>
              </ul>
              <a href="#pro" class="card__cta cta" id="machine-two" data-open-modal-machine="choose-machine">Invest
                Now</a>
            </div>
          </div>

          <div class="cards__card card">
            <figure class="blog-banner img-holder">
              <img src="./assets/images/m3.jpeg" width="400" height="290" loading="lazy" alt="Step 1"
                class="img-cover" />
            </figure>
            <div class="card__content">
              <h2 class="card__heading" id="k-series">K-series (K1)</h2>
              <p class="card__price">Minimum Ksh 16,000</p>
              <input type="hidden" id="k1" name="k1" readonly required value="16000">
              <input type="hidden" id="k1-id" name="k1-id" readonly required value="3">
              <ul role="list" class="card__bullets flow">
                <li>Top 10 US Stocks</li>
                <li>Return on investment 200%</li>
                <li>24/7 Priority support</li>
              </ul>
              <a href="#ultimate" class="card__cta cta" id="machine-three"
                data-open-modal-machine="choose-machine">Invest Now</a>
            </div>
          </div>

          <div class="cards__card card">
            <figure class="blog-banner img-holder">
              <img src="./assets/images/m4.jpeg" width="400" height="290" loading="lazy" alt="Step 1"
                class="img-cover" />
            </figure>
            <div class="card__content">
              <h2 class="card__heading">M-series (M1)</h2>
              <p class="card__price">Minimum Ksh 8,000</p>
              <ul role="list" class="card__bullets flow">
                <li>Top 10 US Stocks</li>
                <li>Return on investment 200%</li>
                <li>Weekly Income Ksh 10,000</li>
                <li>24/7 Priority support</li>
              </ul>
              <a href="#pro" class="card__cta cta">Invest Now</a>
            </div>
          </div>

          <div class="cards__card card">
            <figure class="blog-banner img-holder">
              <img src="./assets/images/m1.jpeg" width="400" height="290" loading="lazy" alt="Step 1"
                class="img-cover" />
            </figure>
            <div class="card__content">
              <h2 class="card__heading">K-series (K1)</h2>
              <p class="card__price">Minimum Ksh 16,000</p>
              <ul role="list" class="card__bullets flow">
                <li>Top 10 US Stocks</li>
                <li>Return on investment 200%</li>
                <li>Weekly Income Ksh 10,000</li>
                <li>24/7 Priority support</li>
              </ul>
              <a href="#ultimate" class="card__cta cta">Invest Now</a>
            </div>
          </div>

          <div class="cards__card card">
            <figure class="blog-banner img-holder">
              <img src="./assets/images/m1.jpeg" width="400" height="290" loading="lazy" alt="Step 1"
                class="img-cover" />
            </figure>
            <div class="card__content">
              <h2 class="card__heading">K-series (K1)</h2>
              <p class="card__price">Minimum Ksh 16,000</p>
              <ul role="list" class="card__bullets flow">
                <li>Top 10 US Stocks</li>
                <li>Return on investment 200%</li>
                <li>Weekly Income Ksh 10,000</li>
                <li>24/7 Priority support</li>
              </ul>
              <a href="#ultimate" class="card__cta cta">Invest Now</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </article>

</main>
<?php include_once './includes/footer.php'; ?>
<script src="./assets/js/form-data.js"></script>

<?php include_once './includes/footer-end.php'; ?>