<header id="page-topbar">
  <div class="layout-width">
    <div class="navbar-header">
      <div class="d-flex">
        <div class="navbar-brand-box horizontal-logo">
          <a href="<?php echo site_url('admin') ?>" class="logo logo-dark">
            <span class="logo-sm">
              <img src="<?php echo base_url('assets/clouds/drives/brand/' . $this->brand->logo_light) ?>" alt="" width="90" height="">
            </span>
            <span class="logo-lg">
              <img src="<?php echo base_url('assets/clouds/drives/brand/' . $this->brand->logo_light) ?>" alt="" width="90" height="">
            </span>
          </a>
          <a href="<?php echo site_url('admin') ?>" class="logo logo-light">
            <span class="logo-sm">
              <img src="<?php echo base_url('assets/clouds/drives/brand/' . $this->brand->logo_light) ?>" alt="" width="90" height="">
            </span>
            <span class="logo-lg">
              <img src="<?php echo base_url('assets/clouds/drives/brand/' . $this->brand->logo_light) ?>" alt="" width="90" height="">
            </span>
          </a>
        </div>
        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
          <span class="hamburger-icon">
            <span></span>
            <span></span>
            <span></span>
          </span>
        </button>
        <div id="live-clock" class="fs-15 fw-semibold d-flex align-items-center" style="gap:0.3rem"></div>
      </div>
      <div class="d-flex align-items-center">
        <div class="ms-1 header-item d-none d-sm-flex">
          <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
            <i class='bx bx-fullscreen fs-22'></i>
          </button>
        </div>
        <div class="ms-1 header-item d-none d-sm-flex">
          <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
            <i class='bx bx-moon fs-22'></i>
          </button>
        </div>
        <!-- notification -->
        
        <!-- end notification -->
        <div class="dropdown ms-sm-3 header-item topbar-user">
          <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center">
              <?php if ($this->session->userdata('foto')) : ?>
                <?php if ($this->session->userdata('is_pegawai') == 1) : ?>
                  <img class="rounded-circle header-profile-user" src="<?php echo $this->session->userdata('foto') ?>" alt="Header Avatar">
                <?php else : ?>
                  <img class="rounded-circle header-profile-user" src="<?php echo base_url('assets/clouds/drives/avatars/' . $this->session->userdata('foto')) ?>" alt="Header Avatar">
                <?php endif; ?>
              <?php else : ?>
                <img class="rounded-circle header-profile-user bg-white p-1" src="<?php echo base_url('assets/clouds/drives/avatars/avatar.png') ?>" alt="Header Avatar">
              <?php endif; ?>

              <span class="text-start ms-xl-2">
                <span class="d-none d-xl-inline-block ms-1 fw-semibold user-name-text"><?php echo $this->session->userdata('nama_pegawai') ?></span>
                <span class="d-none d-xl-block ms-1 fs-13 text-muted user-name-sub-text"><?php echo $this->session->userdata('nomenklatur_jabatan') ?></span>
              </span>
            </span>
          </button>
          <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header"><?php echo $this->session->userdata('nip') ?></h6>
            <h5 class="dropdown-header fw-bold pt-0" style="font-size:16px;color:#132649;">
              <?php echo $this->session->userdata('nama_pegawai') ?><?php echo $this->session->userdata('gelar_belakang') !== '-' ? ', ' . $this->session->userdata('gelar_belakang') : '' ?>
            </h5>
            <h6 class="dropdown-header" style="font-size:14px"><?php echo $this->session->userdata('nomenklatur_jabatan') ?></h6>
            <h6 class="dropdown-header pt-0"><?php echo $this->session->userdata('instansi') ?></h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" onclick="logout()">
              <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
              <span class="align-middle" data-key="t-logout">Logout</span>
            </a>
            <script>
              function logout() {
                localStorage.clear()
                location.href = '<?php echo site_url('auth/logout') ?>'
              }
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>