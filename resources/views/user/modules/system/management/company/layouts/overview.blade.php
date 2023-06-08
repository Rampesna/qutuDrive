<div class="card mb-6 mb-xl-9">
    <div class="card-body pt-9 pb-0">
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bolder">
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 {{ request()->segment(6) === 'index' ? 'active' : '' }}" href="{{ route('user.web.system.management.company.detail.index', ['id' => $id]) }}">Genel Bilgiler</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 {{ request()->segment(6) === 'package' ? 'active' : '' }}" href="{{ route('user.web.system.management.company.detail.package', ['id' => $id]) }}">Paketler</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 {{ request()->segment(6) === 'backupStatus' ? 'active' : '' }}" href="{{ route('user.web.system.management.company.detail.backupStatus', ['id' => $id]) }}">Yedek Durumu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 {{ request()->segment(6) === 'eLedgerBackupStatus' ? 'active' : '' }}" href="{{ route('user.web.system.management.company.detail.eLedgerBackupStatus', ['id' => $id]) }}">e-Defter İkincil Saklama</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-active-primary py-5 me-6 {{ request()->segment(6) === 'user' ? 'active' : '' }}" href="{{ route('user.web.system.management.company.detail.user', ['id' => $id]) }}">Kullanıcılar</a>
            </li>
        </ul>
    </div>
</div>
