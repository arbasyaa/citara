<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Service;

class ServicesManager extends Component
{
    use WithPagination, WithFileUploads;

    public $title, $description, $link, $image, $editingId;
    protected $rules = [
        'title' => 'required|string',
        'description' => 'nullable|string',
        'link' => 'nullable|url',
        'image' => 'nullable|image|max:4096',
    ];

    public function resetForm()
    {
        $this->title = $this->description = $this->link = $this->image = $this->editingId = null;
    }

    public function create()
    {
        $this->validate();
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'link' => $this->link,
        ];
        if ($this->image) {
            $path = $this->image->store('uploads', 'public');
            $data['image'] = $path;
        }
        Service::create($data);
        session()->flash('success', 'Service created');
        $this->resetForm();
    }

    public function edit(Service $service)
    {
        $this->editingId = $service->id;
        $this->title = $service->title;
        $this->description = $service->description;
        $this->link = $service->link;
    }

    public function update()
    {
        $this->validate();
        $service = Service::findOrFail($this->editingId);
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'link' => $this->link,
        ];
        if ($this->image) {
            $path = $this->image->store('uploads', 'public');
            $data['image'] = $path;
        }
        $service->update($data);
        session()->flash('success', 'Service updated');
        $this->resetForm();
    }

    public function delete(Service $service)
    {
        $service->delete();
        session()->flash('success', 'Service deleted');
    }

    public function render()
    {
        return view('livewire.services-manager', [
            'services' => Service::latest()->paginate(10),
        ]);
    }
}
