import React, { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Checkbox } from '@/components/ui/checkbox';
import { Label } from '@/components/ui/label';
import toast from 'react-hot-toast';
import InputError from '@/components/input-error';
import { LoaderCircle, Eye, EyeOff } from 'lucide-react';
import Swal from "sweetalert2";

interface LoginProps {
  status?: string;
}

export default function Login({ status }: LoginProps) {
  const [showPassword, setShowPassword] = useState(false);

  const { data, setData, post, processing, errors, reset } = useForm({
    nis: '',
    password: '',
    remember: false,
  });

  const submit = (e: React.FormEvent) => {
    e.preventDefault();

    post('/login', {
      onSuccess: () => {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil Login!',
          text: 'Selamat datang kembali 👋',
          timer: 2000,
          showConfirmButton: false
        });
        reset('password');
      },
      onError: (errors) => {
        let errorMsg = 'Login gagal. Silakan periksa kembali data Anda.';
        if (errors.nis) errorMsg = errors.nis;
        else if (errors.password) errorMsg = errors.password;
        
        Swal.fire({
          icon: 'error',
          title: 'Login Gagal',
          text: errorMsg
        });
      },
      onFinish: () => reset('password'),
    });
  };

  return (
    <>
      <Head title="Login" />

      <main className="min-h-screen flex bg-[rgb(224,234,232)]">
        {/* Left Section */}
        <div className="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-[rgb(47,106,98)] to-[rgb(34,80,73)] relative overflow-hidden">
          <div className="absolute inset-0 opacity-20">
            <svg className="w-full h-full" xmlns="http://www.w3.org/2000/svg">
              <defs>
                <pattern id="pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
                  <circle cx="25" cy="25" r="15" fill="white" opacity="0.3" />
                  <circle cx="75" cy="25" r="10" fill="white" opacity="0.2" />
                  <circle cx="50" cy="50" r="20" fill="white" opacity="0.25" />
                  <circle cx="25" cy="75" r="12" fill="white" opacity="0.2" />
                  <circle cx="75" cy="75" r="15" fill="white" opacity="0.3" />
                </pattern>
              </defs>
              <rect x="0" y="0" width="100%" height="100%" fill="url(#pattern)" />
            </svg>
          </div>

          <div className="absolute top-8 left-8 z-10">
            <img src="/assets/images/logos/logo-64.png" alt="Mathesia Logo" className="h-12" />
          </div>

          <div className="relative z-10 flex items-center justify-center w-full p-12">
            <div className="text-white text-center">
              <h2 className="text-4xl font-bold mb-4">Selamat Datang di Mathesia</h2>
              <p className="text-lg opacity-90">
                Platform pembelajaran matematika online inovatif <br /> untuk masa depan siswa
              </p>
            </div>
          </div>
        </div>

        {/* Right Section */}
        <div className="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-8 lg:p-12">
          <div className="w-full max-w-md">
            <div className="lg:hidden flex justify-center mb-8">
              <img src="/assets/images/logos/logo-64.png" alt="Mathesia Logo" className="h-12" />
            </div>

            <div className="text-center mb-8">
              <h1 className="text-3xl font-bold text-gray-800 mb-2">Selamat Datang</h1>
              <p className="text-gray-600">Masuk dengan NIS dan password terdaftar</p>
            </div>

            {/* Form Login */}
            <form onSubmit={submit} className="space-y-6">
              {/* NIS */}
              <div>
                <Label htmlFor="nis" className="text-gray-800">
                  NIS
                </Label>
                <Input
                  id="nis"
                  name="nis"
                  type="text"
                  value={data.nis}
                  onChange={(e) => setData('nis', e.target.value)}
                  placeholder="Masukkan NIS Anda"
                  className="mt-2 bg-white text-gray-800"
                  required
                />
                <InputError message={errors.nis} />
              </div>

              {/* Password */}
              <div>
                <Label htmlFor="password" className="text-gray-800">
                  Password
                </Label>
                <div className="relative mt-2">
                  <Input
                    id="password"
                    name="password"
                    type={showPassword ? 'text' : 'password'}
                    value={data.password}
                    onChange={(e) => setData('password', e.target.value)}
                    placeholder="Masukkan password Anda"
                    className="w-full pr-10 bg-white text-gray-800"
                    required
                  />
                  <button
                    type="button"
                    onClick={() => setShowPassword(!showPassword)}
                    className="absolute right-3 top-2 text-gray-600 hover:text-gray-800"
                  >
                    {showPassword ? <EyeOff /> : <Eye />}
                  </button>
                </div>
                <InputError message={errors.password} />
              </div>

              {/* Remember */}
              <div className="flex items-center space-x-2">
                <Checkbox
                  id="remember"
                  checked={data.remember}
                  onCheckedChange={(checked) => setData('remember', !!checked)}
                />
                <Label htmlFor="remember" className="text-gray-800">
                  Remember me
                </Label>
              </div>

              {/* Button */}
              <Button type="submit" className="w-full mt-4" disabled={processing}>
                {processing && <LoaderCircle className="h-4 w-4 animate-spin mr-2" />}
                Masuk
              </Button>

              {status && (
                <div className="mt-4 text-center text-sm text-green-600">{status}</div>
              )}
            </form>

            <div className="mt-8 text-center text-sm text-gray-500">
              © Mathesia IRS UNP {new Date().getFullYear()}
            </div>
          </div>
        </div>
      </main>
    </>
  );
}
