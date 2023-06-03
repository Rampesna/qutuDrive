<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title'){{ config('app.name') }}</title>
    <meta charset="utf-8"/>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.png') }}"/>
    <meta name="viewport" content="width=device-width, shrink-to-fit=no"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>

    <link id="themePlugin" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet"
          type="text/css"/>
    <link id="themeBundle" href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('assets/plugins/custom/selectpicker/css/bootstrap-select.css') }}" rel="stylesheet"
          type="text/css"/>

    @yield('customStyles')

</head>

<body id="kt_body" class="header-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"
      style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">

<div id="loader"></div>

<div class="d-flex flex-column flex-root" id="rootDocument">
    <div class="page d-flex flex-row flex-column-fluid">

        @include('user.layouts.sidebar')
        @include('user.layouts.body')

    </div>
</div>

<div class="hideIfMobile">
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="black"/>
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="black"/>
            </svg>
        </span>
    </div>
</div>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/63da13d5474251287910ce20/1go5tquub';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->

<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script src="{{ asset('assets/js/jquery.touchSwipe.js') }}"></script>

<script src="{{ asset('assets/js/custom.js') }}"></script>

<script src="{{ asset('assets/plugins/custom/selectpicker/js/bootstrap-select.js') }}"></script>



<script>

    var authUserId = parseInt(localStorage.getItem('authUserId'));
    var authUserToken = localStorage.getItem('authUserToken');
    var authUserSelectedCompanyId = parseInt(localStorage.getItem('authUserSelectedCompanyId'));
    var authUserType = localStorage.getItem('authUserType');

    function checkLogin() {
        if (
            !authUserId ||
            !authUserToken ||
            !authUserSelectedCompanyId
        ) {
            window.location.href = '{{ route('user.web.authentication.login.index') }}';
        }

        if (parseInt(authUserType) === 2) {
            $('.showIfOnlyManager').show();
        } else {
            $('.showIfOnlyManager').hide();
        }

        $('#authUserNameSpan').html(localStorage.getItem('authUserName'));
        $('#authUserEmailSpan').html(localStorage.getItem('authUserEmail'));
    }

    checkLogin();

    function logout() {
        localStorage.removeItem('authUserId');
        localStorage.removeItem('authUserToken');
        localStorage.removeItem('authUserSelectedCompanyId');
        localStorage.removeItem('authUserType');
        localStorage.removeItem('authUserName');
        localStorage.removeItem('authUserEmail');
        window.location.href = '{{ route('user.web.authentication.login.index') }}';
    }

    var userCompanies = [];
    var SelectedCompany = $('#SelectedCompany');
    var jqxGridGlobalTheme = 'metro';
    var baseAssetUrl = '{{ asset('') }}';

    var waitingDatabaseBackDownloadsRow = $('#waitingDatabaseBackDownloadsRow');

    function getCompanies() {
        $.ajax({
            async: false,
            type: 'get',
            url: '{{ route('user.api.getCompanies') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {},
            success: function (response) {
                console.log(response);
                userCompanies = response.response;
                SelectedCompany.empty();
                $.each(response.response, function (i, company) {
                    SelectedCompany.append($('<option>', {
                        value: company.ID,
                        text: company.FIRMAUNVAN,
                    }));
                });
                SelectedCompany.val(authUserSelectedCompanyId);
            },
            error: function (error) {
                console.log(error);
                if (parseInt(error.status) === 422) {
                    $.each(error.responseJSON.response, function (i, error) {
                        toastr.error(error[0]);
                    });
                } else {
                    toastr.error(error.responseJSON.message);
                }
            }
        });
    }

    getCompanies();

    $(SelectedCompany).on('select2:select', function (e) {
        $('#loader').show();
        var companyId = parseInt(e.params.data.id);
        $.ajax({
            type: 'post',
            url: '{{ route('user.api.setSelectedCompany') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: companyId
            },
            success: function (response) {
                window.location.reload();
            },
            error: function (error) {
                console.log(error);
                if (parseInt(error.status) === 422) {
                    toastr.error(error.message);
                } else {
                    toastr.error(error.message);

                }
            }
        });
    });

    function changeLanguage(locale) {
        $.ajax({
            type: 'put',
            url: '{{ route('user.web.changeLanguage') }}',
            headers: {
                'Accept': 'application/json',
            },
            data: {
                locale: locale,
            },
            success: function () {
                location.reload();
            },
            error: function (error) {
                console.log(error);
                toastr.error(error.responseJSON.message);
            }
        });
    }

    function getWaitingDatabaseBackupDownloadsByUserId() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.waitingDatabaseBackupDownload.getByUserId') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {},
            success: function (response) {
                waitingDatabaseBackDownloadsRow.empty();
                $.each(response.response, function (i, waitingDatabaseBackDownload) {
                    var statusBadge = ``;
                    var statusName = ``;
                    var downloadLinkHtml = `<span class="fs-6 text-gray-800 text-hover-primary fw-bolder">${waitingDatabaseBackDownload.backupdosyalar.DOSYAADI}</span>`;
                    var cancelIconHtml = ``;

                    if (waitingDatabaseBackDownload.status_id === 1) {
                        statusBadge = `badge-light-warning`;
                        statusName = `Bekliyor`;
                        cancelIconHtml = `<i class="fa fa-times-circle fa-lg text-danger cursor-pointer waitingDatabaseBackupDownloadCancelIcon" data-id="${waitingDatabaseBackDownload.id}"></i>`;
                    } else if (waitingDatabaseBackDownload.status_id === 2) {
                        statusBadge = `badge-light-info`;
                        statusName = `İşleme Alındı`;
                    } else if (waitingDatabaseBackDownload.status_id === 3) {
                        statusBadge = `badge-light-success`;
                        statusName = `Tamamlandı`;
                        downloadLinkHtml = `<a href="${waitingDatabaseBackDownload.download_link}" target="_blank" class="fs-6 text-gray-800 text-hover-primary fw-bolder">${waitingDatabaseBackDownload.backupdosyalar.DOSYAADI}</a>`;
                    } else if (waitingDatabaseBackDownload.status_id === 5) {
                        statusBadge = `badge-secondary`;
                        statusName = `İptal Edildi`;
                    } else {
                        statusBadge = `badge-light-danger`;
                        statusName = `Hata`;
                    }

                    waitingDatabaseBackDownloadsRow.append(`
                    <div class="col-xl-12" id="waitingDatabaseBackupDownloadCol_${waitingDatabaseBackDownload.id}">
                        <div class="d-flex flex-stack py-4">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-35px me-4">
                                    ${cancelIconHtml}
                                </div>
                                <div class="mb-0 me-2">
                                    ${downloadLinkHtml}
                                </div>
                            </div>
                            <span class="badge ${statusBadge} fs-8">
                                ${statusName}
                            </span>
                        </div>
                    </div>
                    `);
                });
                console.log(response);
            },
            error: function (error) {
                console.log(error);
                if (parseInt(error.status) === 422) {
                    $.each(error.responseJSON.response, function (i, error) {
                        toastr.error(error[0]);
                    });
                } else {
                    toastr.error(error.responseJSON.message);
                }
            }
        });
    }

    getWaitingDatabaseBackupDownloadsByUserId();

    $(document).delegate('.waitingDatabaseBackupDownloadCancelIcon', 'click', function () {
        $(this).removeClass('fa-times-circle').addClass('fa-spinner fa-spin');
        var id = parseInt($(this).data('id'));
        $.ajax({
            type: 'post',
            url: '{{ route('user.api.waitingDatabaseBackupDownload.cancel') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                id: id,
            },
            success: function () {
                getWaitingDatabaseBackupDownloadsByUserId();
            },
            error: function (error) {
                console.log(error);
                if (parseInt(error.status) === 422) {
                    $.each(error.responseJSON.response, function (i, error) {
                        toastr.error(error[0]);
                    });
                } else {
                    toastr.error(error.responseJSON.message);
                }
            }
        });
    });

</script>

@yield('customScripts')

</body>
</html>
