import { ref, watch, onMounted } from 'vue';

const theme = ref(localStorage.getItem('theme') || 'dark');

export function useTheme() {
    const toggleTheme = () => {
        theme.value = theme.value === 'dark' ? 'light' : 'dark';
    };

    watch(theme, (newTheme) => {
        localStorage.setItem('theme', newTheme);
        if (newTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });

    onMounted(() => {
        if (theme.value === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            theme.value = 'dark';
        } else {
            document.documentElement.classList.remove('dark');
            theme.value = 'light';
        }
    });

    return {
        theme,
        toggleTheme
    };
}
