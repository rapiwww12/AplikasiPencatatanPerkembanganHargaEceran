import { Button } from '@/components/ui/button';
import { Form, FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import AppLayout from '@/layouts/app-layout';
import { zodResolver } from '@hookform/resolvers/zod';
import { Head, Link, router } from '@inertiajs/react';
import dayjs from 'dayjs';
import { useEffect } from 'react';
import { FormProvider, useForm } from 'react-hook-form';
import { toast } from 'sonner';

import * as z from 'zod';

type BahanBaku = {
    id: number;
    nama: string;
};

interface Props {
    bahanBaku: BahanBaku;
    flash: {
        success: string | null;
        error: string | null;
    };
}

export default function CreateHarga({ bahanBaku, flash }: Props) {
    const formSchema = z.object({
        harga: z.coerce.number({ invalid_type_error: 'Harga harus berupa angka' }).min(1, 'Harga tidak boleh kosong'),
        bahan_baku_id: z.number({ invalid_type_error: 'ID bahan baku harus berupa angka' }).min(1, 'ID bahan baku tidak valid'),
        pasar: z.string().min(1, 'Pasar harus dipilih'),
    });

    type FormValues = z.infer<typeof formSchema>;

    const methods = useForm<FormValues>({
        resolver: zodResolver(formSchema),
        defaultValues: {
            harga: undefined,
            bahan_baku_id: bahanBaku.id,
            pasar: '',
        },
    });

    const { handleSubmit } = methods;

    const onSubmit = (data: FormValues) => {
        router.post(`/items/${bahanBaku.id}/harga/store`, {
            harga: data.harga,
            bahan_baku_id: Number(data.bahan_baku_id),
            pasar: data.pasar,
        });
    };

    useEffect(() => {
        if (flash.success) toast.success(flash.success);
        if (flash.error) toast.error(flash.error);
    }, [flash]);

    return (
        <AppLayout
            breadcrumbs={[
                { title: 'Bahan Baku', href: '/items' },
                { title: bahanBaku.nama, href: `/items/${bahanBaku.id}` },
                { title: 'Input Harga', href: '#' },
            ]}
        >
            <Head title={`Harga ${bahanBaku.nama}`} />
            <div className="m-10 flex max-w-full flex-col gap-4 rounded-xl border p-4">
                <h1 className="text-xl font-semibold">Input Harga - {bahanBaku.nama}</h1>
                <FormProvider {...methods}>
                    <Form {...methods}>
                        <form onSubmit={handleSubmit(onSubmit)} className="space-y-6">
                            <FormField
                                name="harga"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel>Harga Hari Ini ({dayjs().format('DD/MM/YYYY')})</FormLabel>
                                        <FormControl>
                                            <Input type="number" placeholder="Contoh: 25000" {...field} />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                )}
                            />

                            <FormField
                                name="pasar"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel>Pasar</FormLabel>
                                        <Select onValueChange={field.onChange} defaultValue={field.value}>
                                            <FormControl>
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Pilih pasar" />
                                                </SelectTrigger>
                                            </FormControl>
                                            <SelectContent>
                                                <SelectItem value="pasar betung">Pasar Betung</SelectItem>
                                                <SelectItem value="pasar sukomoro">Pasar Sukomoro</SelectItem>
                                                <SelectItem value="pasar sukajadi">Pasar Sukajadi</SelectItem>
                                                <SelectItem value="pasar kenten laut">Pasar Kenten Laut</SelectItem>
                                                <SelectItem value="pasar pangkalan balai">Pasar Pangkalan Balai</SelectItem>
                                            </SelectContent>
                                        </Select>
                                        <FormMessage />
                                    </FormItem>
                                )}
                            />

                            <div className="flex justify-end space-x-2">
                                <Button type="submit">Simpan</Button>
                                <Link href={'/items'}>
                                    <Button type="button">Kembali</Button>
                                </Link>
                            </div>
                        </form>
                    </Form>
                </FormProvider>
            </div>
        </AppLayout>
    );
}
