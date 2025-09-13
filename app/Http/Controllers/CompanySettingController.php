<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanySetting;
use App\Services\CloudinaryService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CompanySettingController extends Controller
{
    public function edit()
    {
        $setting = CompanySetting::first();
        return view('admins.settings.company.edit', [
            'setting' => $setting,
        ]);
    }

    public function update(Request $request, CloudinaryService $cloudinaryService)
    {
        $companySetting = CompanySetting::firstOrFail();

        $data = $request->all();

        // Social links JSON
        $data['social_links'] = [
            'facebook'  => $request->input('facebook_link'),
            'youtube'   => $request->input('youtube_link'),
            'tiktok'    => $request->input('tiktok_link'),
            'instagram' => $request->input('instagram_link'),
        ];

        // Google map JSON
        $data['google_map'] = $request->input('google_map', [
            'map_1' => ['embed_url' => '', 'coordinates' => ['lat' => null, 'lng' => null]],
            'map_2' => ['embed_url' => '', 'coordinates' => ['lat' => null, 'lng' => null]],
        ]);

        // Xử lý logo
        if ($request->hasFile('company_logo')) {
            if (!empty($companySetting->company_logo_public_id)) {
                $cloudinaryService->delete($companySetting->company_logo_public_id);
            }
            $uploadResult = $cloudinaryService->upload($request->file('company_logo'), 'company_settings/logo');
            $data['company_logo'] = $uploadResult['url'] ?? null;
            $data['company_logo_public_id'] = $uploadResult['path'] ?? null;
        } else {
            $data['company_logo'] = $companySetting->company_logo;
            $data['company_logo_public_id'] = $companySetting->company_logo_public_id;
        }

        // Xử lý certificates
        if ($request->hasFile('certificates')) {
            if (!empty($companySetting->certificates_public_ids)) {
                foreach ($companySetting->certificates_public_ids as $publicId) {
                    $cloudinaryService->delete($publicId);
                }
            }

            $newCertificates = [];
            $newCertificatesPublicIds = [];
            foreach ($request->file('certificates') as $certificate) {
                $uploadResult = $cloudinaryService->upload($certificate, 'company_settings/certificates');
                $newCertificates[] = $uploadResult['url'] ?? null;
                $newCertificatesPublicIds[] = $uploadResult['path'] ?? null;
            }
            $data['certificates'] = $newCertificates;
            $data['certificates_public_ids'] = $newCertificatesPublicIds;
        } else {
            $data['certificates'] = $companySetting->certificates;
            $data['certificates_public_ids'] = $companySetting->certificates_public_ids;
        }

        $companySetting->update($data);

        return redirect()->route('admin.settings.company.edit')
            ->with('success', 'Cập nhật thông tin công ty thành công!');
    }


    public function editPolicy()
    {
        $policyContent = CompanySetting::value('policy_content') ?? '';
        return view('admins.settings.policy.edit', [
            'policyContent' => $policyContent,
        ]);
    }

    public function updatePolicy(Request $request)
    {
        $request->validate([
            'policy_content' => 'nullable|string',
            'admin_password' => 'required|string',
        ]);

        // Kiểm tra mật khẩu admin
        $user = Auth::user();
        if (!$user || !Hash::check($request->input('admin_password'), $user->password)) {
            return redirect()->back()
                ->withErrors(['admin_password' => 'Mật khẩu quản trị viên không đúng.'])
                ->withInput();
        }

        $companySetting = CompanySetting::first() ?? new CompanySetting();

        // Lưu thẳng nội dung policy, không xử lý Base64
        $companySetting->policy_content = $request->input('policy_content', '');
        $companySetting->save();

        return redirect()->back()->with('success', 'Cập nhật chính sách công ty thành công!');
    }
}
