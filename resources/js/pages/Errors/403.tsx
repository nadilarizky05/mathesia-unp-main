import ErrorLayout from './ErrorLayout';

export default function Error403() {
  return (
    <ErrorLayout
      code={403}
      title="Akses Dilarang"
      message="Anda tidak memiliki izin untuk mengakses halaman ini."
    />
  );
}
