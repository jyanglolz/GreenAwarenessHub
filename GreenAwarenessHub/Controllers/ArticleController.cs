using Microsoft.AspNetCore.Mvc;
using GreenAwarenessHub.Models;
using GreenAwarenessHub.Data;
using Microsoft.EntityFrameworkCore;

namespace GreenAwarenessHub.Controllers
{
    public class ArticleController : Controller
    {
        private GreenAwarenessHubContext _context;

        public ArticleController(GreenAwarenessHubContext context)
        {
            _context =  context;
        }


        public IActionResult Index()
        {
            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> submitArticle(Article article)
        {
            if (!ModelState.IsValid) //if form is not valid
            {
                return View(article); //return back to previous page
            }


            _context.Articles.Add(article);  //keep the changes
            await _context.SaveChangesAsync();
            return RedirectToAction("Index", "Article");
        }


    }
}
