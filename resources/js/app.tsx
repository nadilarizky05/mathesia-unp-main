import '../css/app.css';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
import { initializeTheme } from './hooks/use-appearance';
import { Toaster } from 'react-hot-toast';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
  title: (title) => (title ? `${title} - ${appName}` : appName),
  resolve: (name) =>
    resolvePageComponent(
      `./pages/${name}.tsx`,
      import.meta.glob('./pages/**/*.tsx')
    ),
  setup({ el, App, props }) {
    const root = createRoot(el);

    root.render(
      <>
        {/* Inertia context dibungkus di dalam sini */}
        <App {...props} />
        {/* Toaster harus di dalam render yang sama */}
        <Toaster position="top-center" reverseOrder={false} />
      </>
    );
  },
  progress: {
    color: '#4B5563',
  },
});

// Inisialisasi tema (dark/light)
initializeTheme();
