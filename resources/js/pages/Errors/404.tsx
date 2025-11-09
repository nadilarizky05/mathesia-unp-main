import ErrorLayout from './ErrorLayout';

export default function Error404() {
  return (
    <ErrorLayout
      code={404}
      title="Halaman Tidak Ditemukan"
      message="Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan."
    />
  );
}
