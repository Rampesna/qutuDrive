<script>

    $(document).ready(function () {
        $('#loader').hide();
    });

    var base64regex = /^([0-9a-zA-Z+/]{4})*(([0-9a-zA-Z+/]{2}==)|([0-9a-zA-Z+/]{3}=))?$/;

    var companyId = parseInt(base64regex.test(`{{ $id }}`) ? atob(`{{ $id }}`) : 0);

    var backupdosyalarSpan = $('#backupdosyalarSpan');
    var syncdosyahareketSpan = $('#syncdosyahareketSpan');
    var edefterdosyalarSpan = $('#edefterdosyalarSpan');

    var getBackupDosyalarUsageStatus = 0;
    var getSyncDosyaHareketUsageStatus = 0;
    var getEdefterDosyalarUsageStatus = 0;

    var getBackupDosyalarUsageSizeMb = null;
    var getSyncDosyaHareketUsageSizeMb = null;
    var getEdefterDosyalarUsageSizeMb = null;

    function setGeneralUsage(
        generalUsageGb
    ) {
        let totalUsageMb = getBackupDosyalarUsageSizeMb + getSyncDosyaHareketUsageSizeMb + getEdefterDosyalarUsageSizeMb;
        let remainingUsageMb = (generalUsageGb * 1024) - totalUsageMb;

        $('#generalUsage').html(`${formatBytes(
            remainingUsageMb * 1024 * 1024, 2
        )} / ${formatBytes((generalUsageGb * 1024 * 1024 * 1024), 2)}`);
    }

    function getBackupDosyalarUsage() {
        $.ajax({
            async: false,
            type: 'get',
            url: '{{ route('user.api.backupdosyalar.getUsage') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: companyId
            },
            success: function (response) {
                getBackupDosyalarUsageSizeMb = response.response[0].BackupDosyalarUsage ?? 0;
                getBackupDosyalarUsageStatus = 1;
                // backupdosyalarSpan.html(`${reformatNumberToMoney((response.response[0].BackupDosyalarUsage ?? 0))} MB`);
                backupdosyalarSpan.html(`${formatBytes(response.response[0].BackupDosyalarUsage * 1024 * 1024 ?? 0, 2)}`);
                getFirmaPaketleriUsage();
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

    function getEdefterDosyalarUsage() {
        $.ajax({
            async: false,
            type: 'get',
            url: '{{ route('user.api.edefterdosyalar.getUsage') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: companyId
            },
            success: function (response) {
                getEdefterDosyalarUsageSizeMb = response.response[0].EDefterDosyalarUsage ?? 0;
                getEdefterDosyalarUsageStatus = 1;
                // edefterdosyalarSpan.html(`${reformatNumberToMoney((response.response[0].EDefterDosyalarUsage ?? 0) / 1024)} MB`);
                edefterdosyalarSpan.html(`${formatBytes(response.response[0].EDefterDosyalarUsage * 1024 * 1024 ?? 0, 2)}`);
                getFirmaPaketleriUsage();
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

    function getSyncDosyaHareketUsage() {
        $.ajax({
            async: false,
            type: 'get',
            url: '{{ route('user.api.syncdosyahareket.getUsage') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: companyId
            },
            success: function (response) {
                getSyncDosyaHareketUsageSizeMb = response.response[0].SyncDosyaHareketUsage ?? 0;
                getSyncDosyaHareketUsageStatus = 1;
                // syncdosyahareketSpan.html(`${reformatNumberToMoney((response.response[0].SyncDosyaHareketUsage ?? 0) / 1024)} MB`);
                syncdosyahareketSpan.html(`${formatBytes(response.response[0].SyncDosyaHareketUsage * 1024 * 1024 ?? 0, 2)}`);
                getFirmaPaketleriUsage();
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

    function getFirmaPaketleriUsage() {
        if (
            getBackupDosyalarUsageStatus === 1 &&
            getSyncDosyaHareketUsageStatus === 1 &&
            getEdefterDosyalarUsageStatus === 1
        ) {
            $.ajax({
                type: 'get',
                url: '{{ route('user.api.firmapaketleri.getUsage') }}',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': authUserToken
                },
                data: {
                    companyId: companyId
                },
                success: function (response) {
                    console.log(response);
                    setGeneralUsage(response.response[0] ? (response.response[0].PAKETBOYUTU ?? 0) : 0);
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
    }

    function getBalanceInquiry() {
        $.ajax({
            type: 'get',
            url: '{{ route('user.api.apiAyssoft.BalanceInquiry.Index') }}',
            headers: {
                'Accept': 'application/json',
                'Authorization': authUserToken
            },
            data: {
                companyId: companyId
            },
            success: function (response) {
                $('#balanceSpan').html(`₺ ${reformatNumberToMoney(response.response.value.balance ?? 0)}`);
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

    getBackupDosyalarUsage();
    getEdefterDosyalarUsage();
    getSyncDosyaHareketUsage();
    getBalanceInquiry();

</script>
