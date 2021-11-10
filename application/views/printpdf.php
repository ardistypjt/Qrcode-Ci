<html>
  <head>
    <title>KTM</title>
  </head>
  <body>
          <form method="POST" action="<?php echo base_url()."index.php/crud/pdf"; ?>" >
            <div style="
            width: 280px;
            height: 350px;
          background-color: #383636;
            /* mix-blend-mode: normal;
            border: 1px solid #000000;
            text-align: center;">
              <h3 style="color:#fff2bc;">UPN VETERAN JAWA TIMUR</h3>
              <br>
              <img style="width: 100px; height: 100px; margin: 5px;" src="<?=$imgurl?>">
              <br>
              <h4 style="color: #fff2bc;">KARTU TANDA MAHASISWA</h4>
              <p class="title" style="background:#806f66;  width: 280px;">Fakultas Ilmu Komputer
                <br>
                Teknik Informatika
                <br>
                <br>
              <?php echo $npm; ?>
              <br>
              <?php echo $namamhs; ?>
               <br>
              <?php echo $alamatmhs; ?>
              <br>
             <?php echo $jeniskelamin; ?>
            </p>
            </div>

            </div>
          </form>
    </body>
</html>
