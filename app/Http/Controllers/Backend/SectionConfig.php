<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\SectionFive;
use App\Models\SectionFour;
use App\Models\SectionOne;
use App\Models\SectionSeven;
use App\Models\SectionSix;
use App\Models\SectionThree;
use App\Models\SectionTwo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionConfig extends Controller
{
    public function switchView($number)
    {
        return match ((int)$number) {
            1 => $this->sectionOneConfigView(),
            2 => $this->sectionTwoConfigView(),
            3 => $this->sectionThreeConfigView(),
            4 => $this->sectionFourConfigView(),
            5 => $this->sectionFiveConfigView(),
            6 => $this->sectionSixConfigView(),
            7 => $this->sectionSevenConfigView(),
            8 => $this->sectionEightConfigView(),
            default => 0,
        };
    }
    public function switchPost(Request $request, $number)
    {
        return match ((int)$number) {
            1 => $this->sectionOneConfigPost($request),
            2 => $this->sectionTwoConfigPost($request),
            3 => $this->sectionThreeConfigPost($request),
            4 => $this->sectionFourConfigPost($request),
            5 => $this->sectionFiveConfigPost($request),
            6 => $this->sectionSixConfigPost($request),
            7 => $this->sectionSevenConfigPost($request),
            8 => $this->sectionEightConfigPost($request),
            default => abort(404),
        };
    }

    private function sectionOneConfigView()
    {
        $one = SectionOne::query()->firstOrCreate();
        return view('backend.section.one', compact('one'));
    }

    private function sectionOneConfigPost(Request $request)
    {
        $one = SectionOne::query()->first();

        $data = $request->except(['bg_image']);

        if ($request->hasFile('bg_image')) {
            $data['bg_image'] = uploadImages($request->file('bg_image'));
            deleteImage($one->bg_image);
        }

        $one->update($data);

        return handleResponse('Lưu thay đổi thành công.', 201);
    }

    private function sectionTwoConfigView()
    {
        $two = SectionTwo::query()->firstOrCreate();
        return view('backend.section.two', compact('two'));
    }

    private function sectionTwoConfigPost(Request $request)
    {
        $request->validate([
            'video_path' => 'nullable|mimes:mp4,mov,avi,flv|max:50000',
        ]);

        $two = SectionTwo::query()->first();

        $data = $request->except(['video_path']);

        if ($request->hasFile('video_path')) {
            $data['video_path'] = Storage::put('videos', $request->file('video_path'));
            deleteImage($two->video_path);
        }

        $two->update($data);

        return handleResponse('Lưu thay đổi thành công.', 201);
    }

    private function sectionThreeConfigView()
    {
        $three = SectionThree::query()->firstOrCreate();
        return view('backend.section.three', compact('three'));
    }

    private function sectionThreeConfigPost(Request $request)
    {

        $three = SectionThree::query()->first();

        $data = $request->except(['bg_image']);

        if ($request->hasFile('bg_image')) {
            $data['bg_image'] = uploadImages($request->file('bg_image'));
            deleteImage($three->bg_image);
        }

        $data['content'] = collect($request->content)->filter()->values()->all();

        $three->update($data);

        return handleResponse('Lưu thay đổi thành công.', 201);
    }

    private function sectionFourConfigView()
    {
        $four = SectionFour::query()->firstOrCreate();
        $images = collect($four->album_slider)->map(function ($item, $index) {
            return [
                'src' => showImage($item),
                'id' => $index,
            ];
        });

        return view('backend.section.four', compact('four', 'images'));
    }

    private function sectionFourConfigPost(Request $request)
    {
        $four = SectionFour::query()->first();

        $existingImages = $four->album_slider ?? [];
        $oldImages = $request->old ?? [];
        $newImages = [];

        foreach ($existingImages as $index => $image) {
            if (in_array($index, $oldImages)) {
                $newImages[] = $image;
            } else {
                deleteImage($image);
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->images as $image) {
                $newImages[] = uploadImages($image);
            }
        }

        $options = array_filter(array_map(function ($option) {
            return array_filter($option, function ($value) {
                return !is_null($value);
            });
        }, $request->options));

        $request->merge([
            'album_slider' => $newImages,
            'options' => $options
        ]);

        $four->update($request->all());

        return handleResponse('Lưu thay đổi thành công.', 201);
    }

    private function sectionFiveConfigView()
    {
        $five = SectionFive::query()->firstOrCreate();
        return view('backend.section.five', compact('five'));
    }

    private function sectionFiveConfigPost(Request $request)
    {
        $five = SectionFive::query()->first();
        $albums = $five->albums ?? []; // Lấy danh sách albums hiện tại
        $data = $request->except(['albums', 'deletedImages']);

        // Lấy danh sách index cần xóa từ input hidden
        $deletedImages = explode(',', $request->deletedImages ?? '');

        // Chuyển keys của $albums thành mảng để kiểm tra
        $albumKeys = array_keys($albums);

        // Xóa các album theo index có trong deletedImages
        foreach ($deletedImages as $deletedIndex) {
            if (in_array($deletedIndex, $albumKeys)) {
                if (isset($albums[$deletedIndex]['image'])) {
                    deleteImage($albums[$deletedIndex]['image']); // Xóa ảnh khỏi server
                }
                unset($albums[$deletedIndex]); // Xóa phần tử trong danh sách albums
            }
        }

        if ($request->has('albums')) {
            foreach ($request->albums as $index => $album) {
                // Nếu index này đã bị xóa thì bỏ qua
                if (in_array($index, $deletedImages)) {
                    continue;
                }

                // Giữ lại ảnh cũ nếu không có ảnh mới
                $imagePath = $albums[$index]['image'] ?? '';

                // Nếu có ảnh mới thì cập nhật
                if (isset($album['image']) && $album['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = uploadImages($album['image']);
                }

                // Cập nhật lại album
                $albums[$index] = [
                    'title' => $album['title'] ?? '',
                    'image' => $imagePath,
                ];
            }
        }

        $data['albums'] = array_values($albums); // Reset lại index để tránh lỗ hổng trong mảng

        $five->update($data);

        return handleResponse('Lưu thay đổi thành công.', 201);
    }

    private function sectionSixConfigView()
    {
        $six = SectionSix::query()->firstOrCreate();
        return view('backend.section.six', compact('six'));
    }

    private function sectionSixConfigPost(Request $request)
    {
        $six = SectionSix::query()->first();

        // Lọc các phần tử có ít nhất một giá trị null
        $filteredComments = array_filter($request->comments ?? [], function ($comment) {
            return !in_array(null, $comment, true); // Kiểm tra nếu có null thì loại bỏ
        });

        $data = $request->except('comments'); // Lấy dữ liệu khác ngoài comments
        $data['comments'] = array_values($filteredComments); // Reset lại index

        $six->update($data);

        return handleResponse('Lưu thay đổi thành công.', 201);
    }

    private function sectionSevenConfigView()
    {
        $seven = SectionSeven::all()->map(function ($item) {
            return [
                'id' => $item->id,
                'icon' => $item->icon,
                'title' => $item->title,
                'content' => $item->content,
            ];
        })->toArray();

        $maxId = !empty($seven) ? max(array_column($seven, 'id')) : 0;

        return view('backend.section.seven', compact('seven', 'maxId'));
    }

    private function sectionSevenConfigPost(Request $request)
    {
        $request->validate([
            'supports' => ['required', 'array', 'min:1'],
            'supports.*.icon' => ['required', 'string'],
            'supports.*.title' => ['required', 'string'],
            'supports.*.content' => ['required', 'string'],
        ], [
            'supports.required' => 'Vui lòng thêm ít nhất một mục hỗ trợ.',
            'supports.*.icon.required' => 'Icon không được để trống.',
            'supports.*.title.required' => 'Tiêu đề không được để trống.',
            'supports.*.title.min' => 'Tiêu đề phải có ít nhất 3 ký tự.',
            'supports.*.content.required' => 'Nội dung không được để trống.',
            'supports.*.content.min' => 'Nội dung phải có ít nhất 5 ký tự.',
        ]);

        $savedIds = [];

        foreach ($request->supports as $key => $support) {
            if (str_contains($key, 'new_')) {
                // Tạo mới mục hỗ trợ
                $newItem = SectionSeven::create([
                    'icon' => $support['icon'],
                    'title' => $support['title'],
                    'content' => $support['content'],
                ]);
                $savedIds[] = $newItem->id;
            } else {
                // Cập nhật mục đã có trong DB
                SectionSeven::where('id', $key)->update([
                    'icon' => $support['icon'],
                    'title' => $support['title'],
                    'content' => $support['content'],
                ]);
                $savedIds[] = $key;
            }
        }

        // Xóa các mục không có trong danh sách mới
        SectionSeven::whereNotIn('id', $savedIds)->delete();

        return handleResponse('Lưu thay đổi thành công.', 201);
    }

    private function sectionEightConfigView()
    {
        $config = Config::query()->firstOrCreate();
        return view('backend.section.eight', compact('config'));
    }

    private function sectionEightConfigPost(Request $request)
    {

        $config = Config::query()->first();

        $data = $request->except('logo', 'icon');

        if ($request->hasFile('logo')) {
            $data['logo'] = uploadImages($request->file('logo'));
            deleteImage($config->logo);
        }

        if ($request->hasFile('icon')) {
            $data['icon'] = uploadImages($request->file('icon'));
            deleteImage($config->icon);
        }

        $config->update($data);

        return handleResponse('Lưu thay đổi thành công.', 201);
    }
}
