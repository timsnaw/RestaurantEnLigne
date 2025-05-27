
    <!--footer-->
    <footer class="modern-footer observe">

        <div class="footer-col brand">
            <a href="index.php?page=home"><img src="public/img/logo1.png" width="70px"></a><br><br>
            <font color="black">
                <p>Mardi – Samedi : 12h00 – 23h00</p>
                <p><strong>Fermé le dimanche</strong></p>
                <p>La meilleure nourriture du pays</p>
            </font>
        </div>

        <div class="footer-col">
            <h4>Contact</h4>
            <p><strong>Adresse :</strong> 12 Rue des Délices, Errachidia, Maroc</p>
            <p>Téléphone : +212 5 22 33 44 XX</p>
            <p>Email : fastyum@gmail.ma</p>
        </div>

        <div class="footer-col">
        <h4>Menu</h4>
        <ul>
          <?php foreach ($categories as $index => $categorie): ?>
                <li class="nav-item">
                    <a class="dropdown-link" <?php echo $index === 0 ? 'active' : ''; ?> 
                       href="index.php?page=menu#tab-<?php echo htmlspecialchars($categorie['categorie_id']); ?>">
                        <?php echo htmlspecialchars($categorie['nom_categorie']); ?>
                    </a>
                </li>
        <?php endforeach; ?>
        </ul>
      </div>

        <div class="footer-col">
            <h4>Contactez-nous</h4>
            <form onsubmit="sendToWhatsApp(event)">
                <textarea id="whatsappMessage" placeholder="Message" required></textarea>
                <button type="submit">Envoyer</button>
            </form>
            
        </div>

    </footer>
    <div class="container-fluid copyright" style="background: linear-gradient(to right, orange, orangered); color: white;">
    <div class="container">
        <div class="row text-white align-items-center">
         
            <div class="col-md-4 text-start mb-2 mb-md-0">
                &copy; <a href="index.php?page=home" class="text-white">
                    <strong style="color: red;">Fast&Yum</strong>
                </a>, All Right Reserved.
            </div>

            <div class="col-md-4 d-flex justify-content-center gap-3 mb-2 mb-md-0" style="flex-wrap: wrap;">
                <span>Designed & Developed By:</span>
                <strong style="color: black;">Eddyani Ayoub & Lhoussin Taouchikht</strong>
               
                <strong style="color: black;"></strong>
            </div>
            <div class="col-md-4 text-end">
               
            </div>
        </div>
    </div>
</div>


    <!-- Footer End -->