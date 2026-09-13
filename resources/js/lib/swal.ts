import Swal from 'sweetalert2';

/**
 * Standard SweetAlert2 configuration for BAPPERIDA Kabupaten Pringsewu.
 * Matches brand identity: Deep Teal, Clean Slate, Warm Amber, and Rose accents.
 */
const defaultCustomClasses = {
    popup: 'rounded-2xl shadow-2xl border border-slate-100 p-6 font-sans text-slate-800',
    title: 'text-xl font-bold text-slate-900 mb-2 tracking-tight',
    htmlContainer: 'text-sm text-slate-600 leading-relaxed',
    confirmButton:
        'inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-medium text-sm text-white bg-teal-700 hover:bg-teal-800 active:scale-[0.98] transition-all duration-150 shadow-sm mx-1 cursor-pointer outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2',
    cancelButton:
        'inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-medium text-sm text-slate-700 bg-slate-100 hover:bg-slate-200 active:scale-[0.98] transition-all duration-150 mx-1 cursor-pointer outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2',
    denyButton:
        'inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-medium text-sm text-white bg-rose-600 hover:bg-rose-700 active:scale-[0.98] transition-all duration-150 mx-1 cursor-pointer',
};

const bapperidaSwal = Swal.mixin({
    customClass: defaultCustomClasses,
    buttonsStyling: false,
    focusConfirm: false,
    showClass: {
        popup: 'animate-in fade-in zoom-in-95 duration-200',
    },
    hideClass: {
        popup: 'animate-out fade-out zoom-out-95 duration-150',
    },
});

export interface ConfirmDialogOptions {
    title?: string;
    text: string;
    confirmButtonText?: string;
    cancelButtonText?: string;
    isDestructive?: boolean;
}

/**
 * Prompt the user for an explicit action confirmation (e.g. Delete, Publish, Logout).
 * Returns true if confirmed, false if cancelled.
 */
export async function confirmAction({
    title = 'Konfirmasi Tindakan',
    text,
    confirmButtonText = 'Ya, Lanjutkan',
    cancelButtonText = 'Batal',
    isDestructive = false,
}: ConfirmDialogOptions): Promise<boolean> {
    const result = await bapperidaSwal.fire({
        icon: isDestructive ? 'warning' : 'question',
        title,
        text,
        showCancelButton: true,
        confirmButtonText,
        cancelButtonText,
        reverseButtons: true,
        customClass: {
            ...defaultCustomClasses,
            confirmButton: isDestructive
                ? 'inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-medium text-sm text-white bg-rose-600 hover:bg-rose-700 active:scale-[0.98] transition-all duration-150 shadow-sm mx-1 cursor-pointer outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2'
                : 'inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-medium text-sm text-white bg-teal-700 hover:bg-teal-800 active:scale-[0.98] transition-all duration-150 shadow-sm mx-1 cursor-pointer outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2',
            cancelButton:
                'inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-medium text-sm text-slate-700 bg-slate-100 hover:bg-slate-200 active:scale-[0.98] transition-all duration-150 mx-1 cursor-pointer outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2',
        },
    });

    return result.isConfirmed;
}

/**
 * Display a structured success alert.
 */
export function alertSuccess(title: string, text?: string) {
    return bapperidaSwal.fire({
        icon: 'success',
        title,
        text,
        confirmButtonText: 'Tutup',
    });
}

/**
 * Display an error alert.
 */
export function alertError(title: string, text?: string) {
    return bapperidaSwal.fire({
        icon: 'error',
        title,
        text,
        confirmButtonText: 'Mengerti',
    });
}

/**
 * Display an informational alert.
 */
export function alertInfo(title: string, text?: string) {
    return bapperidaSwal.fire({
        icon: 'info',
        title,
        text,
        confirmButtonText: 'Tutup',
    });
}

export default bapperidaSwal;
