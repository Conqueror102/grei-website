@php($topics = ['property' => 'Property enquiry', 'interiors' => 'Interior design', 'stays' => 'Short stay', 'corporate' => 'Corporate stays'])
<x-layouts.app title="Contact" description="Book a private consultation with GREI.">
    <x-hero title="Book a private<br>consultation" cta="Book a call" modal="modal-call" :framed="true"
        :image="config('grei.images.contact')" alt="Sunlit meeting room with a long timber table and floor-to-ceiling windows"
        eyebrow="Contact GREI" icon="chats-circle"
        text="Tell us a little about what you have in mind. A GREI advisor will reply within one working day."
        :chips="[['envelope-simple', 'Email'], ['phone', 'Phone'], ['video-camera', 'Video']]"
        :card="[['clock', 'Reply in one day', 'Monday to Friday'], ['user-circle', 'A named advisor', 'One point of contact'], ['shield-check', 'No obligation', 'Just a conversation']]" />

    <section class="bg-[#F5F5F5] pt-16 md:pt-20 pb-20 md:pb-28">
        <div class="max-w-[1320px] mx-auto px-6 md:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                <div class="lg:col-span-7 bg-white border border-[#EAEAEA] p-8 sm:p-10">
                    <h2 class="text-[22px] font-normal tracking-[-0.02em] mb-6">Send an enquiry</h2>
                    <x-consult-form :topic="$topics[$topic] ?? 'General enquiry'" :cancel="false" submit="Send Enquiry" message-label="How can we help?" />
                </div>
                <div class="lg:col-span-5 bg-white border border-[#EAEAEA] p-8 sm:p-10 flex flex-col">
                    <img src="{{ asset('images/brand/grei-mark-dark-tight.png') }}" alt="" class="h-12 w-auto self-start">
                    <ul class="mt-8 space-y-5 text-[13px]">
                        <li class="flex gap-3"><i class="ph-duotone ph-envelope-simple text-[18px] text-[#8C8C8C]"></i><span><span class="block text-[11px] text-[#8A8A8A]">Email</span><a class="hover:underline" href="mailto:{{ config('grei.contact.email') }}">{{ config('grei.contact.email') }}</a></span></li>
                        <li class="flex gap-3"><i class="ph-duotone ph-phone text-[18px] text-[#8C8C8C]"></i><span><span class="block text-[11px] text-[#8A8A8A]">Phone</span>{{ config('grei.contact.phone') }}</span></li>
                        <li class="flex gap-3"><i class="ph-duotone ph-map-pin text-[18px] text-[#8C8C8C]"></i><span><span class="block text-[11px] text-[#8A8A8A]">Studio</span>{{ config('grei.contact.address') }}</span></li>
                        <li class="flex gap-3"><i class="ph-duotone ph-clock text-[18px] text-[#8C8C8C]"></i><span><span class="block text-[11px] text-[#8A8A8A]">Hours</span>{{ config('grei.contact.hours') }}</span></li>
                    </ul>
                    <div class="mt-auto pt-8 flex flex-wrap gap-3">
                        <button type="button" data-open-modal="modal-call" class="zr-btn-dark">Book a call</button>
                        <button type="button" data-open-modal="modal-list" class="zr-btn-outline">List a property</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
