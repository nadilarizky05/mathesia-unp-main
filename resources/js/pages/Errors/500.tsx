import ErrorLayout from './ErrorLayout';

export default function Error500() {
  return (
    <ErrorLayout
      code={500}
      title="Terjadi Kesalahan Server"
      message="Ups! Ada sesuatu yang salah di sisi server. Silakan coba lagi nanti."
    />
  );
}
