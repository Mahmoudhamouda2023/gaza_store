$(document).ready(function () {
    const isArabic = document.documentElement.lang === 'ar';

    $('.admin-data-table').DataTable({
        pageLength: 10,
        ordering: true,
        searching: true,
        responsive: true,
        autoWidth: false,
        columnDefs: [
            {
                orderable: false,
                targets: 'no-sort'
            }
        ],
        language: {
            search: isArabic ? 'بحث' : 'Search',
            lengthMenu: isArabic ? 'عرض _MENU_ عنصر' : 'Show _MENU_ entries',
            info: isArabic
                ? 'عرض _START_ إلى _END_ من أصل _TOTAL_ عنصر'
                : 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: isArabic ? 'لا توجد بيانات' : 'No data available',
            zeroRecords: isArabic ? 'لا توجد نتائج مطابقة' : 'No matching records found',
          paginate: {
    previous: isArabic
        ? '<i class="fas fa-chevron-right"></i>'
        : '<i class="fas fa-chevron-left"></i>',
    next: isArabic
        ? '<i class="fas fa-chevron-left"></i>'
        : '<i class="fas fa-chevron-right"></i>'
}
        }
    });

    $('.delete-btn').on('click', function (e) {
        e.preventDefault();

        const form = $(this).closest('form');

        Swal.fire({
            title: isArabic ? 'هل أنت متأكد؟' : 'Are you sure?',
            text: isArabic
                ? 'لن تتمكن من التراجع بعد الحذف.'
                : 'You will not be able to undo this action.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: isArabic ? 'نعم، احذف' : 'Yes, delete',
            cancelButtonText: isArabic ? 'إلغاء' : 'Cancel',
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#858796'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });


});
