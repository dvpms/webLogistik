<div class="app-menu navbar-menu">
  <!-- logo -->
  <div class="navbar-brand-box">
    <!-- dark logo-->
    <a href="index.html" class="logo logo-dark">
      <span class="logo-sm">
        <img src="public/assets/clouds/drives/brand/ . <?php echo $this->brand->logo ?>" alt="" width="40" height="">
      </span>
      <span class="logo-lg">
        <img src="public/assets/clouds/drives/brand/ . <?php echo $this->brand->logo_light ?>" alt="" width="60" height="">
      </span>
    </a>
    <!-- light logo-->
    <a href="index.html" class="logo logo-light">
      <span class="logo-sm">
        <img src="public/assets/clouds/drives/brand/ . <?php echo $this->brand->logo ?>" alt="" width="40" height="">
      </span>
      <span class="logo-lg">
        <img src="public/assets/clouds/drives/brand/ .  <?php echo $this->brand->logo_light ?>" alt="" width="60" height="">
      </span>
    </a>
    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover"><i class="ri-record-circle-line"></i></button>
  </div>

  <div id="scrollbar">
    <div class="container-fluid">
      <div id="two-column-menu"></div>
      <ul class="navbar-nav" id="navbar-nav">
        <li class="menu-title"><span data-key="t-menu">Menu Navigasi</span></li>
        <?php if ($this->menus) : ?>
          <?php  
            $jml_inbox = '';
            $jml_draft = '';

            $notif_inbox = isset($this->dashboard[0]['count_inbox']) ? $this->dashboard[0]['count_inbox'] : 0;
            $notif_draft = isset($this->dashboard[0]['count_draft']) ? $this->dashboard[0]['count_draft'] : 0;

            if ($notif_inbox > 0) $jml_inbox = $notif_inbox;
            if ($notif_draft > 0) $jml_draft = $notif_draft;  
          ?>
          <?php foreach ($this->menus as $menu) : ?>
            <?php
              $page = $_SERVER["REQUEST_URI"];
              $page = explode('/', $page);
              $page = end($page);
            ?>
            <?php if ($menu['nodes']) : ?>
              <?php $show = '' ?>
              <?php $active = '' ?>
              <?php foreach ($menu['nodes'] as $row) : ?>
                <?php if ($page === $row['url']) : ?>
                  <?php $show = 'show' ?>
                  <?php $active = 'active' ?>
                <?php endif; ?>
                <?php if ($row['nodes']) : ?>
                  <?php foreach ($row['nodes'] as $row2) : ?>
                    <?php if ($page === $row2['url']) : ?>
                      <?php $show = 'show' ?>
                      <?php $active = 'active' ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                <?php endif; ?>
              <?php endforeach; ?>
              <li class="nav-item">
                <a class="nav-link menu-link <?php echo $active ?>" href="#sidebar-<?php echo $menu['id'] ?>" data-bs-toggle="collapse" role="button">
                  <i class="<?php echo $menu['icon'] ?>"></i>
                  <span><?php echo ucwords($menu['name']) ?></span>
                </a>
                <div class="collapse menu-dropdown <?php echo $show ?>" id="sidebar-<?php echo $menu['id'] ?>">
                  <ul class="nav nav-sm flex-column">
                    <?php foreach ($menu['nodes'] as $child) : ?>
                      <?php if ($child['nodes']) : ?>
                        <?php $show2 = '' ?>
                        <?php $active2 = '' ?>
                        <?php foreach ($child['nodes'] as $row2) : ?>
                          <?php if ($page === $row2['url']) : ?>
                            <?php $show2 = 'show' ?>
                            <?php $active2 = 'active' ?>
                          <?php endif; ?>
                        <?php endforeach; ?>
                        <li class="nav-item">
                          <a href="#sidebar-<?php echo $child['id'] ?>" class="nav-link <?php echo $active2 ?>" data-bs-toggle="collapse" role="button"><?php echo ucwords($child['name']) ?></a>
                          <div class="collapse menu-dropdown <?php echo $show2 ?>" id="sidebar-<?php echo $child['id'] ?>">
                            <ul class="nav nav-sm flex-column">
                              <?php foreach ($child['nodes'] as $child2) : ?>
                                <?php $show3 = '' ?>
                                <?php $active3 = '' ?>
                                <?php if ($page === $child2['url']) : ?>
                                  <?php $show3 = 'show' ?>
                                  <?php $active3 = 'active' ?>
                                <?php endif; ?>
                                <li class="nav-item">
                                  <a href="<?php echo site_url('eo/' . $child2['url']) ?>" class="nav-link <?php echo $active3 ?>"><?php echo ucwords($child2['name']) ?></a>
                                </li>
                              <?php endforeach; ?>
                            </ul>
                          </div>
                        </li>
                      <?php else : ?>
                        <?php $show2 = '' ?>
                        <?php $active2 = '' ?>
                        <?php if ($page === $child['url']) : ?>
                          <?php $show2 = 'show' ?>
                          <?php $active2 = 'active' ?>
                        <?php endif; ?>
                        <li class="nav-item">
                          <a href="<?php echo site_url('eo/' . $child['url']) ?>" class="nav-link <?php echo $active2 ?>"><?php echo ucwords($child['name']) ?></a>
                        </li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </ul>
                </div>
              </li>
            <?php else : ?>
              <?php  
                $notif_inbox = '';
                $notif_draft = '';
                if ($menu['name'] == 'Surat Masuk') $notif_inbox = $jml_inbox;   
                if ($menu['name'] == 'Draft') $notif_draft = $jml_draft;   
              ?>
              <li class="nav-item">
                <a class="nav-link menu-link <?php echo $page === $menu['url'] ? 'active' : '' ?>" href="<?php echo site_url('eo/' . $menu['url']) ?>">
                  <i class="<?php echo $menu['icon'] ?>"></i>
                  <span><?php echo ucwords($menu['name']) ?></span>
                  <span class="badge rounded-pill blinker bg-danger text-white ms-2"><?php echo $notif_inbox ?></span>
                  <span class="badge rounded-pill blinker bg-danger text-white ms-2"><?php echo $notif_draft ?></span>
                </a>
              </li>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </div>
    <!-- sidebar -->
  </div>
  <div class="sidebar-background"></div>
</div>
<!-- left sidebar end -->