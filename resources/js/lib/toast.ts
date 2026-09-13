import { toast } from 'vue-sonner';

/**
 * Toast notifications for BAPPERIDA web portal.
 * Powered by vue-sonner.
 */
export const notify = {
    success: (message: string, description?: string) => {
        toast.success(message, {
            description,
            duration: 4000,
        });
    },

    error: (message: string, description?: string) => {
        toast.error(message, {
            description,
            duration: 5000,
        });
    },

    info: (message: string, description?: string) => {
        toast.info(message, {
            description,
            duration: 4000,
        });
    },

    warning: (message: string, description?: string) => {
        toast.warning(message, {
            description,
            duration: 4500,
        });
    },

    promise: <T>(
        promise: Promise<T>,
        messages: {
            loading: string;
            success: string | ((data: T) => string);
            error: string | ((error: unknown) => string);
        }
    ) => {
        return toast.promise(promise, messages);
    },
};

export { toast };
export default notify;
