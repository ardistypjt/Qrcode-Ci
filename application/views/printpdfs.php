<html>
  <head>
    <title>KTM</title>

  </head>
  <body>
          <form method="POST" action="<?php echo base_url()."index.php/cruds/pdf"; ?>" >
            <div style="
            width: 280px;
            height: 350px;
          background-color: #383636;
            /* mix-blend-mode: normal;
            border: 1px solid #000000;
            text-align: center;">
              <h3 style="color:#fff2bc;">UPN VETERAN JAWA TIMUR</h3>
              <br>
              <img style="width: 100px; height: 100px; margin: 7px;" src="<?=$imgurl?>">
              <br>
              <h4 style="color: #fff2bc;">KARTU TANDA MAHASISWA</h4>
              <p class="title" style="background:#806f66;  width: 280px;">Fakultas Ilmu Komputer
                <br>
                Sistem Informasi
                <br>
                <br>
              <?php echo $npms; ?>
              <br>
              <?php echo $namas; ?>
               <br>
              <?php echo $alamats; ?>
              <br>
             <?php echo $jenisk; ?>
            </p>
            </div>

            </div>
          </form>
    </body>
</html>
