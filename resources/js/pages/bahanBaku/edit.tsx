import { Button } from '@/components/ui/button';
import { Form, FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import AppLayout from '@/layouts/app-layout';
import { zodResolver } from '@hookform/resolvers/zod';
import { Head, Link, router } from '@inertiajs/react';
import { FormProvider, useForm } from 'react-hook-form';
import * as z from 'zod';

const formSchema = z.object({
    nama: z.string().min(1, 'Nama bahan baku wajib diisi'),
    satuan: z.string().min(1, 'Satuan wajib diisi'),
    // unit: z.string().optional(), // Aktifkan jika dibutuhkan
});

interface Props {
    item: {
        id: number;
        nama: string;
        satuan: string;
        // unit?: string;
    };
}

export default function EditBahanBaku({ item }: Props) {
    const methods = useForm({
        resolver: zodResolver(formSchema),
        defaultValues: {
            nama: item.nama,
            satuan: item.satuan,
            // unit: item.unit || '',
        },
    });

    const { handleSubmit } = methods;

    const onSubmit = (data: z.infer<typeof formSchema>) => {
        router.put(`/items/${item.id}`, data);
    };

    return (
        <AppLayout
            breadcrumbs={[
                { title: 'Bahan Baku', href: '/bahan-baku' },
                { title: 'Edit', href: '#' },
            ]}
        >
            <Head title="Edit Bahan Baku" />
            <div className="m-10 flex max-h-fit max-w-full flex-1 flex-col gap-4 rounded-xl border p-4">
                <h1 className="text-xl font-semibold">Edit Bahan Baku</h1>
                <FormProvider {...methods}>
                    <Form {...methods}>
                        <form onSubmit={handleSubmit(onSubmit)} className="space-y-6">
                            <FormField
                                name="nama"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel>Nama Bahan Baku</FormLabel>
                                        <FormControl>
                                            <Input placeholder="Contoh: Cabai" {...field} />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                )}
                            />

                            <FormField
                                name="satuan"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel>Satuan</FormLabel>
                                        <FormControl>
                                            <Input placeholder="Contoh: kg, liter, butir" {...field} />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                )}
                            />

                            {/* <FormField
                                name="unit"
                                render={({ field }) => (
                                    <FormItem>
                                        <FormLabel>Unit (opsional)</FormLabel>
                                        <FormControl>
                                            <Input placeholder="Contoh: Unit Gudang" {...field} />
                                        </FormControl>
                                        <FormMessage />
                                    </FormItem>
                                )}
                            /> */}

                            <div className="flex justify-end space-x-2">
                                <Button type="submit">Simpan Perubahan</Button>
                                <Link href="/items">
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
